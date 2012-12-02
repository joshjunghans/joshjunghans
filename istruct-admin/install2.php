<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
	<title>istruct Admin</title> 
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="content-language" content="en-US" />
	<link id="template-style" href="style.css" media="all" rel="stylesheet" />
	<script type="text/javascript" id="jquery" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/finish-install.js"></script>
</head>
<body class="install finish">

	<div id="wrap">
		
		<div id="header_wrap">
			<div id="header">
				<img id="logo" src="images/istruct-logo_86x25.png" title="istruct Admin" alt="istruct" />

				<ul class="menu">
					<li><a href="index.php" title="Admin Home" class="active">Admin Home</a></li>
					<li><a href="site.php" title="Manage Site Settings" class="inactive">Site</a></li>
					<li><a href="pages.php" title="Manage Pages" class="inactive">Pages</a></li>
					<li><a href="add-ons.php" title="Manage Add-ons" class="inactive">Add-ons</a></li>
					<li><a href="users.php" title="Manage Users" class="inactive">Users</a></li>
				</ul>

			</div><!-- #header -->
		</div><!-- #header_wrap -->

		
		<div id="container">
			<div id="content">
			<!-- Start Content -->

				<h1>Set Your Website's Credentials</h1>
				<p>You're almost done!  We just need to set a few more values to finish setup on your website.</p>

				<hr />

				<form method="post" action="func/finish-install.php">
					<span class="required">* All Fields Are Required</span>
					<ul>
						<li>
							<label for="Site_Name">Website Site Name: <span class="char_limit">(75 characters max)</span></label>
							<input type="text" id="Site_Name" name="db[Site_Name]" />
							<span class="blurb">This is used to identify your website.</span>
						</li>
						<li>
							<label for="Site_Domain">Website Domain Name: <span class="char_limit">(50 characters max)</span></label>
							<input type="text" id="Site_Domain" name="db[Site_Domain]" />
							<span class="blurb">Enter the FULL url of your website, including the protocol. <em>Example: http://www.mywebsite.com</em>.  May also be <em>localhost</em>.</span>
						</li>
						<li>
							<label for="Site_Charset">Character Set:</label>
							<select id="Site_Charset" name="db[Site_Charset]">
								<option value="UTF-8" selected="selected">UTF-8</option>
								<option value="UTF-16">UTF-16</option>
								<option value="ISO-8859-1">ISO-8859-1</option>
								<option value="ISO-8859-2">ISO-8859-2</option>
								<option value="ISO-8859-3">ISO-8859-3</option>
								<option value="ISO-8859-4">ISO-8859-4</option>
								<option value="ISO-8859-5">ISO-8859-5</option>
								<option value="ISO-8859-6">ISO-8859-6</option>
								<option value="ISO-8859-7">ISO-8859-7</option>
								<option value="ISO-8859-8">ISO-8859-8</option>
								<option value="ISO-8859-9">ISO-8859-9</option>
								<option value="ISO-8859-10">ISO-8859-10</option>
								<option value="ISO-8859-15">ISO-8859-15</option>
								<option value="ISO-2022-JP">ISO-2022-JP</option>
								<option value="ISO-8822-JP-2">ISO-8822-JP-2</option>
								<option value="ISO-2022-KR">ISO-2022-KR</option>
							</select>
						</li>
						<li>
							<label for="Site_Language">Website Language:</label>
							<select id="Site_Language" name="db[Site_Language]">
								<option value="ab">Abkhazian</option>
								<option value="aa">Afar</option>
								<option value="af">Afrikaans</option>
								<option value="sq">Albanian</option>
								<option value="am">Amharic</option>
								<option value="ar">Arabic</option>
								<option value="an">Aragonese</option>
								<option value="hy">Armenian</option>
								<option value="as">Assamese</option>
								<option value="ay">Aymara</option>
								<option value="az">Azerbaijani</option>
								<option value="ba">Bashkir</option>
								<option value="ea">Basque</option>
								<option value="bn">Bengali (Bangla)</option>
								<option value="dz">Bhutani</option>
								<option value="bh">Bihari</option>
								<option value="bi">Bislama</option>
								<option value="br">Breton</option>
								<option value="bg">Bulgarian</option>
								<option value="my">Burmese</option>
								<option value="be">Byelorussian (Belarusian)</option>
								<option value="km">Cambodian</option>
								<option value="ca">Catalan</option>
								<option value="zh">Chinese (Simplified)</option>
								<option value="zh">Chinese (Traditional)</option>
								<option value="co">Corsican</option>
								<option value="hr">Croatian</option>
								<option value="cs">Czech</option>
								<option value="da">Danish</option>
								<option value="nl">Dutch</option>
								<option value="en" selected="selected">English</option>
								<option value="eo">Esperanto</option>
								<option value="et">Estonian</option>
								<option value="fo">Faeroese</option>
								<option value="fa">Farsi</option>
								<option value="fj">Fiji</option>
								<option value="fi">Finnish</option>
								<option value="fr">French</option>
								<option value="fy">Frisian</option>
								<option value="gl">Galician</option>
								<option value="gd">Gaelic (Scottish)</option>
								<option value="gv">Gaelic (Manx)</option>
								<option value="ka">Georgian</option>
								<option value="de">German</option>
								<option value="el">Greek</option>
								<option value="kl">Greenlandic</option>
								<option value="gn">Guarani</option>
								<option value="gu">Gujarati</option>
								<option value="ht">Haitian Creole</option>
								<option value="ha">Hausa</option>
								<option value="he,iw">Hebrew</option>
								<option value="hi">Hindi</option>
								<option value="hu">Hungarian</option>
								<option value="is">Icelandic</option>
								<option value="io">Ido</option>
								<option value="id, in">Indonesian</option>
								<option value="ia">Interlingua</option>
								<option value="ie">Interlingue</option>
								<option value="iu">Inuktitut</option>
								<option value="ik">Inupiak</option>
								<option value="ga">Irish</option>
								<option value="it">Italian</option>
								<option value="ja">Japanese</option>
								<option value="jv">Javanese</option>
								<option value="kn">Kannada</option>
								<option value="ks">Kashmiri</option>
								<option value="kk">Kazakh</option>
								<option value="rw">Kinyarwanda (Ruanda)</option>
								<option value="ky">Kirghiz</option>
								<option value="rn">Kirundi (Rundi)</option>
								<option value="ko">Korean</option>
								<option value="ku">Kurdish</option>
								<option value="lo">Laothian</option>
								<option value="la">Latin</option>
								<option value="lv">Latvian (Lettish)</option>
								<option value="li">Limburgish ( Limburger)</option>
								<option value="ln">Lingala</option>
								<option value="lt">Lithuanian</option>
								<option value="mk">Macedonian</option>
								<option value="mg">Malagasy</option>
								<option value="ms">Malay</option>
								<option value="ml">Malayalam</option>
								<option value="mt">Maltese</option>
								<option value="mi">Maori</option>
								<option value="mr">Marathi</option>
								<option value="mo">Moldavian</option>
								<option value="mn">Mongolian</option>
								<option value="na">Nauru</option>
								<option value="ne">Nepali</option>
								<option value="no">Norwegian</option>
								<option value="oc">Occitan</option>
								<option value="or">Oriya</option>
								<option value="om">Oromo (Afan, Galla)</option>
								<option value="ps">Pashto (Pushto)</option>
								<option value="pl">Polish</option>
								<option value="pt">Portuguese</option>
								<option value="pa">Punjabi</option>
								<option value="qu">Quechua</option>
								<option value="rm">Rhaeto-Romance</option>
								<option value="ro">Romanian</option>
								<option value="ru">Russian</option>
								<option value="sm">Samoan</option>
								<option value="sg">Sangro</option>
								<option value="sa">Sanskrit</option>
								<option value="sr">Serbian</option>
								<option value="sh">Serbo-Croatian</option>
								<option value="st">Sesotho</option>
								<option value="tn">Setswana</option>
								<option value="sn">Shona</option>
								<option value="ii">Sichuan Yi</option>
								<option value="sd">Sindhi</option>
								<option value="si">Sinhalese</option>
								<option value="ss">Siswati</option>
								<option value="sk">Slovak</option>
								<option value="sl">Slovenian</option>
								<option value="so">Somali</option>
								<option value="es">Spanish</option>
								<option value="su">Sundanese</option>
								<option value="sw">Swahili (Kiswahili)</option>
								<option value="sv">Swedish</option>
								<option value="tl">Tagalog</option>
								<option value="tg">Tajik</option>
								<option value="ta">Tamil</option>
								<option value="tt">Tatar</option>
								<option value="te">Telugu</option>
								<option value="th">Thai</option>
								<option value="bo">Tibetan</option>
								<option value="ti">Tigrinya</option>
								<option value="to">Tonga</option>
								<option value="ts">Tsonga</option>
								<option value="tr">Turkish</option>
								<option value="tk">Turkmen</option>
								<option value="tw">Twi</option>
								<option value="ug">Uighur</option>
								<option value="uk">Ukrainian</option>
								<option value="ur">Urdu</option>
								<option value="uz">Uzbek</option>
								<option value="vi">Vietnamese</option>
								<option value="vo">Volapük</option>
								<option value="wa">Wallon</option>
								<option value="cy">Welsh</option>
								<option value="wo">Wolof</option>
								<option value="xh">Xhosa</option>
								<option value="yi, ji">Yiddish</option>
								<option value="yo">Yoruba</option>
								<option value="zy">Zulu</option>
							</select>
						</li>
					</ul>
					<hr />
					<h2>Create Your User Account</h2>
					<ul>
						<li>
							<label for="User_First">First Name:</label>
							<input type="text" id="User_Email" name="user[User_Email]" />
						</li>
						<li>
							<label for="User_Email">Email Address:</label>
							<input type="text" id="User_Email" name="user[User_Email]" />
						</li>
						<li>
							<label for="User_Pass">Password:</label>
							<input type="password" id="User_Pass" name="user[User_Pass]" />
						</li>
						<li>
							<label for="User_Repass">Retype Password:</label>
							<input type="password" id="User_Repass" name="user[User_Repass]" />
						</li>
					</ul>
					<hr />
					<p style="text-align:center;padding-bottom:15px;">
						<input type="hidden" name="user[User_Role]" value="admin" />
						<input type="submit" class="button large" value="Finish Installation" id="validate_install" />
					</p>
				</form>

			<!-- End Content -->
			</div><!-- #content -->
		</div><!-- #container -->

	</div><!-- #wrap -->

</body>
</html>
