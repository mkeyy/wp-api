<?php

/**
 * Plugin Name: Cookie Policy
 * Plugin URI: http://www.ivision.pl
 * Description: Plugin dodający do strony informację o przechowywaniu danych użytkownika w cookies.
 * Version: 0.2
 * Author: Ivision
 * Author URI: http://www.ivision.pl
 */

function cookie_policy_scripts() {
	wp_enqueue_style( 'cookies-style', plugins_url( 'cookie-policy.min.css', __FILE__ ), array(), false );
	wp_enqueue_script( 'cookie-privacy', plugins_url( 'cookie-policy.min.js', __FILE__ ), array(), false, true );
}

add_action( 'wp_enqueue_scripts', 'cookie_policy_scripts', 1000 );

function cookie_policy_display() {
	$slug = '';

	if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
		$slug = '-' . ICL_LANGUAGE_CODE;
	}

	$cookie_main_heading_opt = 'cookie_main_heading' . $slug;
	$cookie_main_content_opt = 'cookie_main_content' . $slug;
	$cookie_widget_text_opt = 'cookie_widget_text' . $slug;
	$cookie_widget_href_opt = 'cookie_widget_href' . $slug;
	$cookie_widget_close_opt = 'cookie_widget_close' . $slug;

	?>

	<div id="cookie-info" class="reveal-modal">
		<h2><?php echo get_option( $cookie_main_heading_opt ); ?></h2>
		<?php echo wpautop( get_option( $cookie_main_content_opt ) ); ?>
		<a class="close-reveal-modal">&#215;</a>
	</div>

	<div id="cookie-widget">
		<p><?php echo get_option( $cookie_widget_text_opt ); ?> <a href="#" data-reveal-id="cookie-info" class="cookie-link"><?php echo get_option( $cookie_widget_href_opt ); ?></a>.</p>
		<a href="#" id="accept-cookies-checkbox"><span><?php echo get_option( $cookie_widget_close_opt ); ?></span></a>
	</div>
<?php
}

add_action( 'wp_footer', 'cookie_policy_display' );

function cookie_policy_menu() {
	add_options_page( 'Cookie Policy', 'Cookie Policy', 'manage_options', 'cookie-policy-options.php', 'cookie_policy_admin_page' );
}

add_action( 'admin_menu', 'cookie_policy_menu' );

function cookie_policy_admin_page() {
	include( 'cookie-policy-admin.php' );
}

register_activation_hook( __FILE__, 'cookie_install' );

function cookie_install() {

	$slug = '';

	if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
		$slug = '-' . ICL_LANGUAGE_CODE;
		$languages = icl_get_languages( 'skip_missing=0&orderby=name&order=asc&link_empty_to=empty' );
	}

	$cookie_main_heading_opt = 'cookie_main_heading' . $slug;
	$cookie_main_content_opt = 'cookie_main_content' . $slug;
	$cookie_widget_text_opt = 'cookie_widget_text' . $slug;
	$cookie_widget_href_opt = 'cookie_widget_href' . $slug;
	$cookie_widget_close_opt = 'cookie_widget_close' . $slug;

	if ( $languages ) {
		foreach ( $languages as $language ) {
			switch ( $language['language_code'] ) {
				case 'pl':
					update_option( 'cookie_main_heading-pl', 'Zasady przechowywania plików Cookies' );
					update_option( 'cookie_main_content-pl', '<p>Niniejszy serwis internetowy korzysta z plików cookies ("ciasteczek") do przechowywania anonimowych informacji o jego użytkownikach. Służy to zapewnieniu najwyższej jakości świadczonych usług oraz pomaga w doskonaleniu funkcjonalności serwisu. Nigdy nie sprzedajemy ani nie przekazujemy gromadzonych przez nas informacji innym podmiotom.</p><h3>Czym są pliki cookies ?</h3><p>Pliki cookie są małymi plikami  przechowywanymi na komputerze użytkownika w celu zapisania jego preferencji, monitorowania historii odwiedzin witryny, poruszania się między stronami oraz dla umożliwienia zapisywania ustawień między odwiedzinami.  Pliki cookie pomagają właścicielom stron internetowych w zbieraniu statystyk na temat częstotliwości odwiedzin określonych podstron strony oraz w dostosowaniu jej do potrzeb użytkownika tak, aby była bardziej przyjazna i łatwa w obsłudze.</p><h4>Jakie informacje są zbierane przez nasz serwis internetowy?</h4><p>Pliki cookie, z których korzysta serwis używane są do:</p><ul><li>monitorowania liczby i rodzaju odwiedzin strony internetowej, zbierania danych statystycznych na temat liczby użytkowników i schematów korzystania z witryny, w tym danych o numerze IP, urządzeniu, czasie ostatniej wizyty w serwisie, etc.,</li><li>zachowania preferencji użytkownika, układów ekranu, w tym preferowanego języka i kraju użytkownika,</li><li>poprawy szybkości działania i wydajności witryny,</li><li>gromadzenia danych koniecznych do przeprowadzenia transakcji i zakupów.</li><li>gromadzenia danych przez sieci reklamowe.</li></ul><h4>Jak zablokować gromadzenie informacji w plikach cookies?</h4><p>Użytkownik może w każdej chwili wyłączyć akceptowanie plików cookies. Można to zrobić poprzez zmianę ustawień w przeglądarce internetowej i usunięcie wszystkich plików cookie. Zastrzegamy iż wyłączenie obsługi plików może spowodować błędne działanie serwisu.</p>' );
					update_option( 'cookie_widget_text-pl', 'W celu podnoszenia jakości, serwis korzysta z&nbsp;plików cookies, ' );
					update_option( 'cookie_widget_href-pl', 'dowiedz się więcej' );
					update_option( 'cookie_widget_close-pl', 'zamknij' );
					break;
				case 'de':
					update_option( 'cookie_main_heading-de', 'Richtlinien zur Speicherung von Cookies' );
					update_option( 'cookie_main_content-de', '<p>Die vorliegende Website verwendet Cookies zur Speicherung von anonymen Informationen über ihre Benutzer. Das dient dazu, die beste Qualität der erbrachten Dienstleistungen sicherzustellen und hilft dabei, die Funktionalität der Website zu verbessern. Weder verkaufen wir die von uns gespeicherten Informationen noch überlassen wir sie Dritten.</p><h3>Was sind Cookies?</h3><p>Cookies sind kleine Textdateien, die auf dem Rechner des Benutzers gespeichert werden, um seine Präferenzen zu merken, die Geschichte der Website-Besuche zu identifizieren und persönliche Einstellungen für besuchte Websites wiederzuerkennen. Cookies helfen den Inhabern der Websites dabei, Statistiken über die Häufigkeit des Abrufs bestimmter Subwebsites zu sammeln und sie an die Bedürfnisse des Benutzers so anzupassen, dass sie bedienerfreundlicher ist.</p><h4>Welche Informationen werden von unserer Website gesammelt?</h4><p>Cookies, die von dieser Website in Anspruch genommen werden, werden zu folgenden Zwecken verwendet:</p><ul><li>Überwachung der Häufigkeit und Art von Einzelbesuchen der Website, Sammeln von statistischen Daten über die Zahl der Benutzer und Schemen des Benutzens der Website, davon über die IP-Nummer, das Gerät, die Dauerzeit des letzten Zugriffs auf den Seiten usw.,</li><li>Merken persönlicher Einstellungen des Benutzers , der Bildschirmlayouts, davon bevorzugter Sprache und des Landes des Benutzers,</li><li>Verbesserung der Websitegeschwindigkeit und –produktivität,</li><li>Speicherung von Daten, die zu Transaktionen und Einkäufen notwendig sind,</li><li>Speicherung von Daten durch Werbungsnetze.</li></ul><h4>Wie kann die Speicherung von Informationen in Cookies gesperrt werden?</h4><p>Der Benutzer kann jederzeit die Annahme von Cookies ausschalten. Das kann durch die Änderung der Einstellungen im Webbrowser und das Löschen aller Cookies erfolgen. Wir behalten uns vor, dass das Ausschalten von Cookies ein fehlerhaftes Funktionieren der Website verursachen kann.</p>' );
					update_option( 'cookie_widget_text-de', 'Um die Qualität zu verbessern, verwendet die Website Cookies. ' );
					update_option( 'cookie_widget_href-de', 'Erfahren Sie mehr' );
					update_option( 'cookie_widget_close-de', 'Ich akzeptiere' );
					break;
				case 'en':
					update_option( 'cookie_main_heading-en', 'Cookies policy' );
					update_option( 'cookie_main_content-en', '<p>This website uses cookies to store anonymous information about its users. This is to ensure the highest quality of services and helps to improve the functionality of the website. We never sell or pass on to third parties the information we collect.</p><h3>What are cookies?</h3><p>Cookies are small files stored on the users computer in order to save the users preferences, monitor site traffic history, moving between sites and to allow saving settings between visits. Cookies help website owners gather statistics on the frequency of visits to certain areas of the site and tailor it to the users needs so that it is more user-friendly and easy to use.</p><h4>What information is collected by our website?</h4><p>Cookies used by the website are to:</p><ul><li>monitor the number and type of visits to the site, the gathering of statistical data on the number of users and patterns of use of the website, including information about the IP number, the device, the date and time of the last visit to the site, etc.,</li><li>save the users preferences, screen displays, including the users preferred language and country,</li><li>improve the speed and efficiency of the site,</li><li>collect data necessary to make transactions and purchases,</li><li>collect data by advertising networks.</li></ul><h4>How to disable the collection of information in cookies?</h4><p>The user may at any time opt-out of cookies. This can be done by changing the settings in the browser and deleting all cookies. Disabling cookies can cause incorrect operation of the website.</p>' );
					update_option( 'cookie_widget_text-en', 'In order to improve the quality, the website uses cookies, ' );
					update_option( 'cookie_widget_href-en', 'learn more' );
					update_option( 'cookie_widget_close-en', 'Accept' );
					break;
				case 'ru':
					update_option( 'cookie_main_heading-ru', 'Правила хранения файлов cookie' );
					update_option( 'cookie_main_content-ru', '<p>Данный интернет-сервис использует файлы coookie для хранения анонимной информации о его пользователях. Это способствует обеспечению наивысшего качества предоставляемых услуг и помогает в усовершенствовании функциональности сервиса. Мы никогда не продаем или передаем собираемую нами информацию другим субъектам.</p><h3>Чем являются файлы cookie?</h3><p>Файлы cookie - это небольшие файлы, хранящиеся на компьютере пользователя с целью сохранения его предпочтений, наблюдения за историей его посещений страниц, перемещения между страницами, а также для того, чтобы позволить записывать настройки в промежутке между посещениями. Файлы cookie помогают владельцам интернет-страниц собирать статистику о частоте посещаемости определенных подстраниц, а также адаптировать их к потребностям пользователя для создания наиболее удобного и простого в обслуживании сервиса.</p><h4>Какая информация собирается нашим интернет-сервисом?</h4><p>Файлы cookie, которыми пользуется наш сервис, используются для:</p><ul><li>наблюдения за количеством и видом посещений интернет-страницы, сбора статистических данных о количестве пользователей и схем исопльзования сервиса, в том числе данных о номере IP, устройстве, времени последнего посещения и т.д.,</li><li>сохранения предпочтений пользователя, схем экрана, в том числе выбранного языка и страны пользователя,</li><li>улучшения качества работы и эффективности сайта,</li><li>сбора данных, необходимых для осуществления сделок и покупок.</li><li>сбора данных рекламными сетями.</li></ul><h4>Как заблокировать сбор информации в файлах cookie?</h4><p>Пользователь в любой момент может отключить согласие на сбор файлов cookie. Это можно осуществить путем изменения настроек в интернет-браузере и удаления всех файлов cookie. Мы предупреждаем, что отключение обслуживания этих файлов может привести к неправильной работе сервиса.</p>' );
					update_option( 'cookie_widget_text-ru', 'Чтобы улучшить качество, сервис использует файлы cookie - ' );
					update_option( 'cookie_widget_href-ru', 'узнать подробнее' );
					update_option( 'cookie_widget_close-ru', 'Согласен' );
					break;
				default:
					update_option( 'cookie_main_heading' . $language['language_code'], 'Zasady przechowywania plików Cookies' );
					update_option( 'cookie_main_content' . $language['language_code'], '<p>Niniejszy serwis internetowy korzysta z plików cookies ("ciasteczek") do przechowywania anonimowych informacji o jego użytkownikach. Służy to zapewnieniu najwyższej jakości świadczonych usług oraz pomaga w doskonaleniu funkcjonalności serwisu. Nigdy nie sprzedajemy ani nie przekazujemy gromadzonych przez nas informacji innym podmiotom.</p><h3>Czym są pliki cookies ?</h3><p>Pliki cookie są małymi plikami  przechowywanymi na komputerze użytkownika w celu zapisania jego preferencji, monitorowania historii odwiedzin witryny, poruszania się między stronami oraz dla umożliwienia zapisywania ustawień między odwiedzinami.  Pliki cookie pomagają właścicielom stron internetowych w zbieraniu statystyk na temat częstotliwości odwiedzin określonych podstron strony oraz w dostosowaniu jej do potrzeb użytkownika tak, aby była bardziej przyjazna i łatwa w obsłudze.</p><h4>Jakie informacje są zbierane przez nasz serwis internetowy?</h4><p>Pliki cookie, z których korzysta serwis używane są do:</p><ul><li>monitorowania liczby i rodzaju odwiedzin strony internetowej, zbierania danych statystycznych na temat liczby użytkowników i schematów korzystania z witryny, w tym danych o numerze IP, urządzeniu, czasie ostatniej wizyty w serwisie, etc.,</li><li>zachowania preferencji użytkownika, układów ekranu, w tym preferowanego języka i kraju użytkownika,</li><li>poprawy szybkości działania i wydajności witryny,</li><li>gromadzenia danych koniecznych do przeprowadzenia transakcji i zakupów.</li><li>gromadzenia danych przez sieci reklamowe.</li></ul><h4>Jak zablokować gromadzenie informacji w plikach cookies?</h4><p>Użytkownik może w każdej chwili wyłączyć akceptowanie plików cookies. Można to zrobić poprzez zmianę ustawień w przeglądarce internetowej i usunięcie wszystkich plików cookie. Zastrzegamy iż wyłączenie obsługi plików może spowodować błędne działanie serwisu.</p>' );
					update_option( 'cookie_widget_text' . $language['language_code'], 'W celu podnoszenia jakości, serwis korzysta<br/>z plików cookies, ' );
					update_option( 'cookie_widget_href' . $language['language_code'], 'dowiedz się więcej' );
					update_option( 'cookie_widget_close' . $language['language_code'], 'zamknij' );
			}
		}
	} else {
		update_option( $cookie_main_heading_opt, 'Zasady przechowywania plików Cookies' );
		update_option( $cookie_main_content_opt, '<p>Niniejszy serwis internetowy korzysta z plików cookies ("ciasteczek") do przechowywania anonimowych informacji o jego użytkownikach. Służy to zapewnieniu najwyższej jakości świadczonych usług oraz pomaga w doskonaleniu funkcjonalności serwisu. Nigdy nie sprzedajemy ani nie przekazujemy gromadzonych przez nas informacji innym podmiotom.</p><h3>Czym są pliki cookies ?</h3><p>Pliki cookie są małymi plikami  przechowywanymi na komputerze użytkownika w celu zapisania jego preferencji, monitorowania historii odwiedzin witryny, poruszania się między stronami oraz dla umożliwienia zapisywania ustawień między odwiedzinami.  Pliki cookie pomagają właścicielom stron internetowych w zbieraniu statystyk na temat częstotliwości odwiedzin określonych podstron strony oraz w dostosowaniu jej do potrzeb użytkownika tak, aby była bardziej przyjazna i łatwa w obsłudze.</p><h4>Jakie informacje są zbierane przez nasz serwis internetowy?</h4><p>Pliki cookie, z których korzysta serwis używane są do:</p><ul><li>monitorowania liczby i rodzaju odwiedzin strony internetowej, zbierania danych statystycznych na temat liczby użytkowników i schematów korzystania z witryny, w tym danych o numerze IP, urządzeniu, czasie ostatniej wizyty w serwisie, etc.,</li><li>zachowania preferencji użytkownika, układów ekranu, w tym preferowanego języka i kraju użytkownika,</li><li>poprawy szybkości działania i wydajności witryny,</li><li>gromadzenia danych koniecznych do przeprowadzenia transakcji i zakupów.</li><li>gromadzenia danych przez sieci reklamowe.</li></ul><h4>Jak zablokować gromadzenie informacji w plikach cookies?</h4><p>Użytkownik może w każdej chwili wyłączyć akceptowanie plików cookies. Można to zrobić poprzez zmianę ustawień w przeglądarce internetowej i usunięcie wszystkich plików cookie. Zastrzegamy iż wyłączenie obsługi plików może spowodować błędne działanie serwisu.</p>' );
		update_option( $cookie_widget_text_opt, 'W celu podnoszenia jakości, serwis korzysta<br/>z plików cookies, ' );
		update_option( $cookie_widget_href_opt, 'dowiedz się więcej' );
		update_option( $cookie_widget_close_opt, 'zamknij' );
	}

}