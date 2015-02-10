<?php
/*
	This function converts the proper language codes into the more simple
	versions used by KBW.
	
	ex. WordPress de_DE => KBW de
*/
function convert_wp_lang_to_valid_language_code( $wp_lang )
{
	switch( strtolower( $wp_lang ) )
	{
		// arabic
		case 'ar':
		case 'ar-ae':
		case 'ar-bh':
		case 'ar-dz':
		case 'ar-eg':
		case 'ar-iq':
		case 'ar-jo':
		case 'ar-kw':
		case 'ar-lb':
		case 'ar-ly':
		case 'ar-ma':
		case 'ar-om':
		case 'ar-qa':
		case 'ar-sa':
		case 'ar-sy':
		case 'ar-tn':
		case 'ar-ye':	return 'ar';
				
		// bulgarian				
		case 'bg':
		case 'bg-bg':	return 'bg';
					
		// bengali
		case 'bn':		return 'bn';
		
		// bosnian
		case 'bs':
		case 'bs-ba':	return 'bs';
		
		// catalan
		case 'ca':
		case 'ca-es':	return 'ca';
		
		// czech
		case 'cs':
		case 'cs-cz':	return 'cs';
		
		case 'cy':		return 'cy';

		// danish
		case 'da':
		case 'da-dk':	return 'da';

		// german
		case 'de':
		case 'de-at':
		case 'de-ch':
		case 'de-de':
		case 'de-li':
		case 'de-lu':	return 'de';

		// greek
		case 'el':
		case 'el-gr':	return 'el';

		// spanish
		case 'es':
		case 'es-ar':
		case 'es-bo':
		case 'es-cl':
		case 'es-co':
		case 'es-cr':
		case 'es-do':
		case 'es-ec':
		case 'es-es':
		case 'es-es':
		case 'es-gt':
		case 'es-hn':
		case 'es-mx':
		case 'es-ni':
		case 'es-pa':
		case 'es-pe':
		case 'es-pr':
		case 'es-py':
		case 'es-sv':
		case 'es-uy':
		case 'es-ve':	return 'es';

		// estonian
		case 'et':
		case 'et-ee':	return 'et';

		// farsi/persian
		case 'fa':
		case 'fa-ir':	return 'fa';

		// finnish
		case 'fi':
		case 'fi-fi':	return 'fi';

		// french
		case 'fr':
		case 'fr-be':
		case 'fr-ca':
		case 'fr-ch':
		case 'fr-fr':
		case 'fr-lu':
		case 'fr-mc':	return 'fr';

		// galician
		case 'gl':
		case 'gl-es':	return 'gl';

		// gujarati
		case 'gu':
		case 'gu-in':	return 'gu';

		// hebrew
		case 'he':
		case 'he-il':	return 'he';

		// croatian
		case 'hr':
		case 'hr-ba':
		case 'hr-hr':	return 'hr';

		// hungarian
		case 'hu':
		case 'hu-hu':	return 'hu';

		// armenian
		case 'hy':
		case 'hy-am':	return 'hy';

		// indonesian
		case 'id':
		case 'id-id':	return 'id';

		// italian
		case 'it':
		case 'it-ch':
		case 'it-it':	return 'it';

		// japanese
		case 'ja':
		case 'ja-jp':	return 'ja';

		// kannada
		case 'kn':
		case 'kn-in':	return 'kn';

		// korean
		case 'ko':
		case 'ko-kr':	return 'ko';

		// lithuanian
		case 'lt':
		case 'lt-lt':	return 'lt';

		// latvian
		case 'lv':
		case 'lv-lv':	return 'lv';

		// malay
		case 'ms':
		case 'ms-bn':
		case 'ms-my':	return 'ms';

		// burmese
		case 'my':		return 'my';

		// norwegian
		case 'nb':
		case 'nb-no':	return 'nb';

		// dutch
		case 'nl':
		case 'nl-be':
		case 'nl-nl':	return 'nl';

		// polish
		case 'pl':
		case 'pl-pl':	return 'pl';

		// portuguese
		case 'pt':
		case 'pt-br':
		case 'pt-pt':	return 'pt-br';

		// romanian
		case 'ro':
		case 'ro-ro':	return 'ro';

		// russian
		case 'ru':
		case 'ru-ru':	return 'ru';

		// slovak
		case 'sk':
		case 'sk-sk':	return 'sk';

		// slovenian
		case 'sl':
		case 'sl-si':	return 'sl';

		// albanian
		case 'sq':
		case 'sq-al':	return 'sq';

		// serbian
		case 'sr-ba':
		case 'sr-sp':
		case 'sr-sr':	return 'sr-sr';

		// swedish
		case 'sv':
		case 'sv-fi':
		case 'sv-se':	return 'sv';

		// thai
		case 'th':
		case 'th-th':	return 'th';

		// turkish
		case 'tr':
		case 'tr-tr':	return 'tr';

		// ukranian
		case 'uk':
		case 'uk-ua':	return 'uk';

		// urdu
		case 'ur':
		case 'ur-pk':	return 'ur';

		// uzbek
		case 'uz':
		case 'uz-uz':	return 'uz';

		// vietnamese
		case 'vi':
		case 'vi-vn':	return 'vi';

		// chinese/simplified
		case 'zh-cn':	return 'zh-cn';

		// chinese/traditional
		case 'zh':
		case 'zh-hk':
		case 'zh-mo':
		case 'zh-sg':
		case 'zh-tw':	return 'zh-tw';

		/* these don't exist and have no real language code? */

		// malaylam
		case 'ml':	return 'ml';
		
		// assume english
		default:	return '';
	}
}
?>