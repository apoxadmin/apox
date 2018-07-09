/*
 * Copyright 2007-2013 Charles du Jeu - Abstrium SAS <team (at) pyd.io>
 * This file is part of Pydio.
 *
 * Pydio is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Pydio is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Pydio.  If not, see <http://www.gnu.org/licenses/>.
 *
 * The latest code can be found at <http://pyd.io/>.
 */
Class.create("AjxpDataGridEditor", AbstractEditor, {

    _dataSource:null,
    _lists: null,

    initialize: function($super, oFormObject, editorOptions)
    {
        editorOptions = Object.extend({
            fullscreen:true
        }, editorOptions);
        $super(oFormObject, editorOptions);
        this._lists = $A();

    },

    destroy: function(){
        // TODO: Shall we destroy the SVG objects?
        this._lists.each(function(resultPane){
            resultPane.destroy();
        });
        this._lists = $A();
    },

    open : function($super, node){
        $super(node);
        this.node = node;
        if(this.node.getMetadata().get("grid_header_title")){
            this.element.down("#grid_container").insert({before:new Element('div', {className:'tabrow'}).update(this.node.getMetadata().get("grid_header_title"))});
        }
        if(this.node.getMetadata().get("grid_element_class")){
            this.element.addClassName(this.node.getMetadata().get("grid_element_class"));
        }

        this._uniqueSource = this.node.getMetadata().get("grid_datasource");
        if(this._uniqueSource){
            // Add a File List  with correct parameters
            this.fRP = new FetchedResultPane(this.element.down("#grid_container"), {
                displayMode:'list',
                fixedDisplayMode:'list',
                rootNodeLabel:this.node.getLabel(),
                selectionChangeCallback:function(){},
                nodeProviderProperties: this._uniqueSource.toQueryParams()
            });
            this.fRP._dataLoaded = false;
            this.fRP.showElement(true);
            this._lists.push(this.fRP);
        }else{
            var i = 1;
            while(this.node.getMetadata().get("grid_datasource_" + i)){
                var dS = this.node.getMetadata().get("grid_datasource_" + i);
                var title = this.node.getMetadata().get("grid_datatitle_" + i);
                if(title){
                    this.element.down("#grid_container").insert(new Element('div',{className:'multiple_grid_title'}).update(title));
                }
                var newContainer = new Element("div", {id:'grid_container_'+i,className:'multiple_grid_container'});
                this.element.down("#grid_container").insert(newContainer);
                // Add a File List  with correct parameters
                var params = {
                    fit:'content',
                    displayMode:'list',
                    fixedDisplayMode:'list',
                    rootNodeLabel:this.node.getLabel(),
                    selectionChangeCallback:function(){},
                    nodeProviderProperties: dS.toQueryParams()
                };
                if(this.node.getMetadata().get("filesList.sortColumn") != undefined){
                    params['defaultSortColumn'] = this.node.getMetadata().get("filesList.sortColumn");
                    params['defaultSortDescending'] = this.node.getMetadata().get("filesList.sortDescending");
                }
                var frp = new FetchedResultPane(newContainer, params);
                frp._dataLoaded = false;
                frp.showElement(true);
                this._lists.push(frp);
                i++;
            }
        }
        this.element.fire("editor:updateTitle", this.node.getLabel());

    },

    resize: function(size){
        fitHeightToBottom(this.element);
        fitHeightToBottom(this.element.down("#grid_container"));
        this._lists.each(function(pane){
            pane.resize(size);
        });
    }

});