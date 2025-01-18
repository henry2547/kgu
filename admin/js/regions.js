/*
	*	Original script by: Shafiul Azam
	*	ishafiul@gmail.com
	*	Version 3.0
	*	Modified by: Luigi Balzano

	*	Description:
	*	Inserts Countries and/or States as Dropdown List
	*	How to Use:

		In Head section:
		<script type= "text/javascript" src = "countries.js"></script>
		In Body Section:
		Select Country:   <select onchange="print_state('state',this.selectedIndex);" id="country" name ="country"></select>
		<br />
		City/District/State: <select name ="state" id ="state"></select>
		<script language="javascript">print_country("country");</script>	

	*
	*	License: OpenSource, Permission for modificatin Granted, KEEP AUTHOR INFORMATION INTACT
	*	Aurthor's Website: http://shafiul.progmaatic.com
	*
*/

var country_arr = new Array("Central Region", "Coast Region", "Eastern Region", "Nairobi Region", "North Eastern Region", "Nyanza Region", "Rift Valley Region", "Western Region");
var s_a = new Array();

s_a[0] = "";
s_a[1] = "Nyandarua|Nyeri|Kirinyaga|Maragua|Murang'a|Thika|Kiambu";
s_a[2] = "Mombasa|Kwale|Kilifi|Tana River|Lamu|TaitaTaveta";
s_a[3] = "Marsabit|Isiolo|Meru|Tharaka-Nithi|Embu|Kitui|Machakos|Makueni";
s_a[4] = "Dagoretti North|Dagoretti South|Lang'ata|Kibra|Kasarani|Roysambu|Ruaraka|Embakasi Central|Embakasi East|Embakasi North|Embakasi South|Embakasi West|Kamukunji|Makadara|Mathare|Starehe|Westlands";
s_a[5] = "Garissa|Mandera|Wajir";
s_a[6] = "Siaya|Kisumu|Homa Bay|Migori|Kisii|Nyamira";
s_a[7] = "Uasin Gishu|Transnzoia|Turkana|Baringo|Marakwet|West Pokot|Kericho|Nandi|Samburu|Naivasha|Laikipia|Narok|Kajiado";
s_a[8] = "Kakamega|Bungoma|Vihiga|Busia";




function print_country(country_id){
	// given the id of the <select> tag as function argument, it inserts <option> tags
	var option_str = document.getElementById(country_id);
	option_str.length=0;
	option_str.options[0] = new Option('Select Region','');
	option_str.selectedIndex = 0;
	for (var i=0; i<country_arr.length; i++) {
		option_str.options[option_str.length] = new Option(country_arr[i],country_arr[i]);
	}
}

function print_state(state_id, state_index){
	var option_str = document.getElementById(state_id);
	option_str.length=0;	// Fixed by Julian Woods
	option_str.options[0] = new Option('Select District','');
	option_str.selectedIndex = 0;
	var state_arr = s_a[state_index].split("|");
	for (var i=0; i<state_arr.length; i++) {
		option_str.options[option_str.length] = new Option(state_arr[i],state_arr[i]);
	}
}
