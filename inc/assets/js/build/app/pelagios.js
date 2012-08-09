/**
 * Pelagios common library
 * @license GPL v3(see LICENSE.txt)
 */

define(["jquery","app/util","app/search_map","app/place_map","lib/text!template/widget_container.tmpl","lib/text!template/place.tmpl","lib/text!template/section.tmpl","lib/text!template/flickr.tmpl","lib/text!template/pleiades.tmpl","lib/text!template/pelagios_partner.tmpl","lib/text!template/error.tmpl","lib/text!template/search.tmpl","lib/text!template/annotations.tmpl","lib/text!template/search_results.tmpl","lib/text!template/new_tab.tmpl","lib/text!template/about.tmpl","lib/text!app/dataset.json","jqueryui","lib/jquery_pagination"],function($,util,search_map,place_map,widget_container_tmpl,place_tmpl,section_tmpl,flickr_tmpl,pleiades_tmpl,pelagios_partner_tmpl,error_tmpl,search_tmpl,annotations_tmpl,search_results_tmpl,new_tab_tmpl,about_tmpl,datasetJSON){function Widget(widgetContext){function widgetPopUp(){if(widgetContext.newTab){var e=window.open(),t=Handlebars.templates.new_tab({widgetContext:widgetContext});$(e.document.body).html(t);var n=document.createElement("script");n.type="text/javascript",n.src=widgetContext.baseURL+"lib/require.js",e.document.head.appendChild(n);var r=document.createElement("script");r.type="text/javascript",r.src=widgetContext.baseURL+"place.js",e.document.head.appendChild(r)}else{$(".pelagios .container").hide(),$("#"+widgetContext.widgetID+"-container").show();var i=$("#"+widgetContext.widgetID+"-icon").offset(),s={top:$(window).scrollTop(),left:200};$("#"+widgetContext.widgetID+"-container").offset(s),widgetContext.displayMap&&placeMap.hasOwnProperty("refresh")&&placeMap.refresh()}}function displayPlace(e){debug("DISPLAYING PLACE: pleiadesID: "+e),placeMap={},clearPlace(),showPleiadesData(e),widgetContext.type=="place"&&showAboutInformation(),showPelagiosData(e),showFlickrData(e)}function showAboutInformation(){addSection("about","About Pelagios and this widget",widgetContext.imageDir+"partner_icons/pelagios.png","");var e=Handlebars.templates.about();$("#"+widgetContext.widgetID+"-content-about").append(e)}function clearPlace(){$("#"+widgetContext.widgetID+"-pleiades").empty(),$("#"+widgetContext.widgetID+"-sections").empty()}function showFlickrData(e){function r(t){if(t.hasOwnProperty("photos")&&t.photos.hasOwnProperty("photo")&&t.photos.photo.length>0){addSection("flickr","flickr",widgetContext.imageDir+"icons/flickr-logo.png","Photo sharing website");var n={photo:t.photos.photo.slice(0,config.MAX_PHOTOS_FLICKR-1),pleiadesID:e},r=Handlebars.templates.flickr(n);$("#"+widgetContext.widgetID+"-content-flickr").append(r)}}var t="";widgetContext.pleiadesFlickrGroupOnly&&(t="&group_id=1876758@N22");var n=config.URL_FLICKR_SEARCH+"&machine_tags=pleiades:depicts="+e+t+"&tag_mode=all&api_key="+config.API_KEY_FLICKR+"&jsoncallback=?";util.getAPIData(n,r,!1,config.TIMEOUT_FLICKR,!1)}function showPleiadesData(e){function r(e,t,n){$("#"+widgetContext.widgetID+"-content").empty();if(e.status=="404")var r={title:config.MSG_TITLE_PLACE_NOT_FOUND,msg:config.MSG_PLACE_NOT_FOUND};else var r={title:config.MSG_TITLE_PLEIADES_TIMEOUT,msg:config.MSG_PLEIADES_TIMEOUT};var i=Handlebars.templates.error(r);$("#"+widgetContext.widgetID+"-content").append(i)}function i(e){var t=!1;e.names.length>1&&(t=e.names.join(", "));var n={title:e.names[0]?e.names[0]:"Untitled",description:e.description,altNames:t,pleiadesID:e.id,widgetContext:widgetContext},r=Handlebars.templates.pleiades(n);$("#"+widgetContext.widgetID+"-pleiades").append(r),e.reprPoint!=null&&widgetContext.displayMap&&(placeMap=new place_map.PlaceMap(widgetContext.widgetID+"-map_canvas"),placeMap.setMarker(e.reprPoint,e.names[0])),e.reprPoint==null&&(placeMap=null),showPlace()}var t=config.URL_PLEIADES+e,n=config.URL_PLEIADES+e+"/json";util.getAPIData(n,i,r,config.TIMEOUT_PLEIADES,!0)}function showPelagiosData(e){function n(e){$.each(e,function(n,i){i.hasOwnProperty("root_dataset")&&(i=i.root_dataset);var s;rootDatasetID=i.uri.replace(/http:\/\/pelagios.dme.ait.ac.at\/api\/datasets\//g,""),s=getDatasetInfo(rootDatasetID);if(typeof s!="undefined"){addSection(rootDatasetID,s.title,widgetContext.iconDir+s.iconFileName,s.strapline);var o=new Array;if(typeof i.subsets!="undefined")for(var u=0;u<i.subsets.length;u++)o[u]={},o[u].widgetContext=widgetContext,o[u].title=i.subsets[u].title,o[u].id=i.subsets[u].uri.replace(/http:\/\/pelagios.dme.ait.ac.at\/api\/datasets\//g,""),o[u].references=i.subsets[u].annotations_referencing_place,o[u].multipleReferences=o[u].references>1?!0:!1,o[u].anyReferences=o[u].references>0?!0:!1;else o[0]={},o[0].widgetContext=widgetContext,o[0].title=i.title,o[0].id=rootDatasetID,o[0].references=e[n].annotations_referencing_place,o[0].multipleReferences=o[0].references>1?!0:!1;var a={subdataset:o,rootDatasetID:rootDatasetID,widgetContext:widgetContext},f=Handlebars.templates.pelagios_partner(a);$("#"+widgetContext.widgetID+"-content-"+rootDatasetID).append(f),$("#"+widgetContext.widgetID+"-subdatasets-"+rootDatasetID).css("list-style-image","url("+widgetContext.imageDir+"icons/bullet.png)");for(var u=0;u<o.length;u++)r(o[u])}else debug("ERROR: Could not find info for root dataset "+i.title+" "+t)})}function r(e){$("#"+widgetContext.widgetID+"-subdataset_title-"+e.id).click({id:e.id},o),$("#"+widgetContext.widgetID+"-subdataset_content-"+e.id).hide();var t=function(t){i(t,e.id)};$("#"+widgetContext.widgetID+"-subdataset_pagination-"+e.id).pagination(e.references,{items_per_page:config.NUM_ANNOTATIONS_TO_DISPLAY,callback:t,next_show_always:!1,prev_show_always:!1}),i(0,e.id)}function i(t,n){var r=config.URL_PELAGIOS_API_V2+"datasets/"+n+"/annotations.json?forPlace="+encodeURIComponent(config.URL_PLEIADES+e)+"&limit="+config.NUM_ANNOTATIONS_TO_DISPLAY+"&offset="+t*config.NUM_ANNOTATIONS_TO_DISPLAY+"&callback=?",i=function(e){typeof e.annotations!="undefined"&&e.annotations.length>0&&s(e.annotations,n)};return util.getAPIData(r,i),!1}function s(e,t){var n=new Array;$.each(e,function(e,t){n[e]={},t.hasOwnProperty("target_title")?n[e].label=t.target_title:n[e].label=t.title?t.title:"Item "+(e+1),n[e].uri=t.hasTarget});var r={subdatasetID:t,annotation:n,widgetContext:widgetContext},i=Handlebars.templates.annotations(r);$("#"+widgetContext.widgetID+"-annotations-"+t).empty(),$("#"+widgetContext.widgetID+"-annotations-"+t).append(i),$("#"+widgetContext.widgetID+"-subdataset-"+t).focus()}function o(e){var t=e.data.id;toggleSelectedLink(widgetContext.widgetID+"-subdataset_hits-"+t),$("#"+widgetContext.widgetID+"-subdataset_content-"+t).toggle(),toggleIcon(widgetContext.widgetID+"-toggle-subdataset-"+t)}function u(e){$("#"+widgetID+"-subdataset_content-"+e).hide()}var t=config.URL_PELAGIOS_API_V2+"places/"+encodeURIComponent(config.URL_PLEIADES+e)+"/datasets.json?callback=?";util.getAPIData(t,n,!1,config.TIMEOUT_PELAGIOS,!1)}function displaySearchResults(){var e=config.URL_PELAGIOS_API_V2+"search.json?query="+searchString+"&callback=?";debug("RETRIEVING SEARCH DATA: searchString: "+searchString+" URL:"+e),util.getAPIData(e,displaySearchResultsData,!1,config.TIMEOUT_PELAGIOS,!1)}function displaySearchResultsData(e){$("#"+widgetContext.widgetID+"-search-map").empty(),$("#"+widgetContext.widgetID+"-search-results").empty(),$("#"+widgetContext.widgetID+"-pleiades").empty(),$("#"+widgetContext.widgetID+"-sections").empty();if(e.length>0){var t=new Array;$.each(e,function(e,n){place={},place.label=n.label,place.pleiadesID=n.uri.replace(/.*places.*F/g,""),place.geojson=n,n.feature_type&&(place.feature_type=n.feature_type.replace(/.*place-types\//g,"")),place.content="<h2>"+place.label+"</h2>",place.content+='<p id="'+widgetContext.widgetID+"-info-"+place.pleiadesID+'">View info</p>',place.widgetID=widgetContext.widgetID,t[e]=place});var n={place:t,widgetContext:widgetContext,searchString:searchString},r=Handlebars.templates.search_results(n);$("#"+widgetContext.widgetID+"-search-results").append(r),$(".pelagios .list-results li").css("background-image","url("+widgetContext.imageDir+"place_type_icons/unknown.png)");var i={temple:"temple.png",santuary:"sanctuary.png",river:"river.png","water-open":"river.png",mountain:"mountain.png",island:"island.png",tribe:"tribe.png",settlement:"settlement.png",urban:"settlement.png",people:"people.png",aqueduct:"aqueduct.png",cape:"cape.png",mine:"mine.png",station:"port.png",road:"road.png",villa:"villa.png",wall:"wall.png",province:"people.png"};$.each(i,function(e,t){$(".pelagios .list-results li."+e).css("background-image","url("+widgetContext.imageDir+"place_type_icons/"+t+")")}),widgetContext.displayMap&&(searchMap=new search_map.SearchMap(widgetContext.widgetID+"-search-map_canvas")),$.each(t,function(e,t){widgetContext.displayMap&&searchMap.addMarker(t.geojson,t.label,t.content,function(){s(t.pleiadesID)}),$("#"+widgetContext.widgetID+"-place-"+t.pleiadesID).click(function(){s(t.pleiadesID)})});function s(e){$(".pelagios-search-result-list li").css("text-decoration","none"),$(".pelagios-search-result-list li").css("font-weight","normal"),$("#"+widgetContext.widgetID+"-place-"+e).css("text-decoration","underline"),$("#"+widgetContext.widgetID+"-place-"+e).css("font-weight","bold"),displayPlace(e)}showSearchResults()}else $("#"+widgetContext.widgetID+"-search-results").append("<h3 class='no-search-results'>No matches found for '"+searchString+"'</h3>"),$("#"+widgetContext.widgetID+"-search-results").show()}function hideSearchResults(){$("#"+widgetContext.widgetID+"-search-results-map").hide(),$("#"+widgetContext.widgetID+"-search-results").hide()}function showSearchResults(){widgetContext.displayMap&&($("#"+widgetContext.widgetID+"-search-results-map").show(),searchMap.refresh()),$("#"+widgetContext.widgetID+"-search-results").show()}function hidePlace(){$("#"+widgetContext.widgetID+"-map").hide(),$("#"+widgetContext.widgetID+"-place").hide()}function showPlace(){$("#"+widgetContext.widgetID+"-place").show(),widgetContext.displayMap&&placeMap!=null&&($("#"+widgetContext.widgetID+"-map").show(),placeMap.refresh()),placeMap==null&&$("#"+widgetContext.widgetID+"-map").hide()}function addSection(e,t,n,r){var i={name:e,title:t,iconURL:n,strapline:r,widgetContext:widgetContext},s=Handlebars.templates.section(i);$("#"+widgetContext.widgetID+"-sections").append(s),$("#"+widgetContext.widgetID+"-content-"+e).hide(),$("#"+widgetContext.widgetID+"-header-"+e).click(function(){$("#"+widgetContext.widgetID+"-content-"+e).toggle(),toggleIcon(widgetContext.widgetID+"-toggle-"+e)})}function toggleIcon(e){var t=$("#"+e).attr("src"),n=t==widgetContext.imageDir+"icons/down-arrow.png"?widgetContext.imageDir+"icons/right-arrow.png":widgetContext.imageDir+"icons/down-arrow.png";$("#"+e).attr("src",n)}function toggleSelectedLink(e){var t=$("#"+e),n=t.css("text-decoration"),r=n=="underline"?"none":"underline";t.css("text-decoration",r)}function getDatasetInfo(e){var t;return $.each(dataset,function(e,n){n.id==rootDatasetID&&(t=n)}),t}function debug(e){widgetContext.debug&&console.log(e)}var placeMap={},searchMap={},searchString="";eval(widget_container_tmpl),eval(place_tmpl),eval(section_tmpl),eval(flickr_tmpl),eval(pleiades_tmpl),eval(pelagios_partner_tmpl),eval(error_tmpl),eval(search_tmpl),eval(annotations_tmpl),eval(search_results_tmpl),eval(new_tab_tmpl),eval(about_tmpl);var dataset=$.parseJSON(datasetJSON);typeof $("#"+widgetContext.widgetID)==undefined&&debug("ERROR: $(#"+widgetContext.widgetID+") is undefined"),$("head").append('<link rel="stylesheet" type="text/css" href="'+widgetContext.cssDir+'pelagios.css" media="screen" />');var html=Handlebars.templates.widget_container({widgetContext:widgetContext});$("#"+widgetContext.widgetID).append(html);try{$("#"+widgetContext.widgetID+"-container").draggable()}catch(err){debug("ERROR: Could not make widget draggable")}this.setTypePlace=function(){var e=Handlebars.templates.place({widgetContext:widgetContext});$("#"+widgetContext.widgetID+"-content").append(e),hidePlace(),widgetContext.icon==1&&($("#"+widgetContext.widgetID+"-container").hide(),$("#"+widgetContext.widgetID+"-icon").click(widgetPopUp),widgetContext.onMouseOver&&($("#"+widgetContext.widgetID+"-icon").mouseover(widgetPopUp),$(document).click(function(){$("#"+widgetContext.widgetID+"-container").hide()}),$("#"+widgetContext.widgetID).click(function(e){return e.stopPropagation(),!1})),$("#"+widgetContext.widgetID+"-close-widget").click(function(){$("#"+widgetContext.widgetID+"-container").hide()})),displayPlace(widgetContext.pleiadesID)},this.setTypeSearch=function(){var e=Handlebars.templates.search({widgetContext:widgetContext});$("#"+widgetContext.widgetID+"-content").append(e);var e=Handlebars.templates.place({widgetContext:widgetContext});$("#"+widgetContext.widgetID+"-content").append(e),hidePlace(),hideSearchResults(),$("#"+widgetContext.widgetID+"-search-form").submit(function(){return searchString=$("input:first").val(),displaySearchResults(),!1})}}var config={URL_PELAGIOS_API_V2:"http://pelagios.dme.ait.ac.at/api/",API_KEY_FLICKR:"ddf82df2aba035bfcf14c12a4eff3335",TIMEOUT_PLEIADES:6e3,TIMEOUT_PELAGIOS:6e4,TIMEOUT_FLICKR:6e3,URL_PLEIADES:"http://pleiades.stoa.org/places/",URL_FLICKR_SEARCH:"http://api.flickr.com/services/rest/?format=json&method=flickr.photos.search",MAX_PHOTOS_FLICKR:30,MSG_PLACE_NOT_FOUND:"The place specified for this widget does not exist in the Pleiades gazetteer.",MSG_TITLE_PLACE_NOT_FOUND:"Error: Unknown Place",MSG_PLEIADES_TIMEOUT:"We cannot display the place name and map at the moment because the Pleiades website is not responding. Apologies for the inconvenience and please try again later.",MSG_TITLE_PLEIADES_TIMEOUT:"Error: Pleiades not responding",NUM_ANNOTATIONS_TO_DISPLAY:20};return{Widget:Widget}})