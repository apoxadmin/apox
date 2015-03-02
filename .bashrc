# ~/.bashrc: executed by bash(1) for non-login shells.
 
###############################################################################
# Collinyen's .bashrc File
# 
# Last Modified 09-06-2013
###############################################################################

# EXPORTS
###############################################################################
export HISTFILESIZE=3000 # Bash history should save 3000 commands
export HISTCONTROL=ignoredups # Don't put duplicate lines in the history
#export PATH=/usr/local/cs/bin:$PATH // For Ucla

# Source global definitions
if [ -f /etc/bashrc ]; then
	. /etc/bashrc
fi

alias c='clear'

## a quick way to get out of current directory ##
alias ..='cd ..'
alias .3='cd ../../../'
alias .4='cd ../../../../'
alias .5='cd ../../../../..'

#Grep Output
alias grep='grep --color=auto'

# Git Aliases
alias gd='git diff --color-words'

# Untar
un='tar -xzvf'

# Activate Environment
alias startv='source venv/bin/activate'


