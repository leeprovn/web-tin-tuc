jQuery.fn.exists = function () {
    return jQuery(this).length > 0;
}
jQuery(document).ready(function($) {
	 jQuery('.del_adp').live("click",function(){			if(confirm('Are you sure?')){				jQuery.post(ajaxurl,{action:'leepro_delete_preview',file:jQuery('#in_'+jQuery(this).attr('rel')).val()})				jQuery('#'+jQuery(this).attr('rel')).fadeOut().remove();			}		});
    if($(".plupload-upload-uic").exists()) {
        var pconfig=false;
        $(".plupload-upload-uic").each(function() {
            var $this=$(this);
            var id1=$this.attr("id");			
            var imgId=id1.replace("plupload-upload-ui", "");
            plu_show_thumbs(imgId);
 
            pconfig=JSON.parse(JSON.stringify(base_plupload_config));
 
            pconfig["browse_button"] = imgId + pconfig["browse_button"];
            pconfig["container"] = imgId + pconfig["container"];
            pconfig["drop_element"] = imgId + pconfig["drop_element"];
            pconfig["file_data_name"] = imgId + pconfig["file_data_name"];
            pconfig["multipart_params"]["imgid"] = imgId;
            pconfig["multipart_params"]["_ajax_nonce"] = $this.find(".ajaxnonceplu").attr("id").replace("ajaxnonceplu", "");
 
            if($this.hasClass("plupload-upload-uic-multiple")) {
                pconfig["multi_selection"]=true;
            }
 
            if($this.find(".plupload-resize").exists()) {
                var w=parseInt($this.find(".plupload-width").attr("id").replace("plupload-width", ""));
                var h=parseInt($this.find(".plupload-height").attr("id").replace("plupload-height", ""));
                pconfig["resize"]={
                    width : w,
                    height : h,
                    quality : 90
                };
            }
 
            var uploader = new plupload.Uploader(pconfig);
 
            uploader.bind('Init', function(up){
 
                });
 
            uploader.init();
	
            // a file was added in the queue
            uploader.bind('FilesAdded', function(up, files){
                $.each(files, function(i, file) {
                    $this.find('.filelist').append(
                        '<div class="file" id="' + file.id + '"><b>' +
                        file.name + '</b> (<span>' + plupload.formatSize(0) + '</span>/' + plupload.formatSize(file.size) + ') ' +
                        '<div class="fileprogress"></div></div>');
                });
 
                up.refresh();
                up.start();
            });
 
            uploader.bind('UploadProgress', function(up, file) {
                $('#' + file.id + " .fileprogress").width(file.percent + "%");
                $('#' + file.id + " span").html(plupload.formatSize(parseInt(file.size * file.percent / 100)));
            });
 
            // a file was uploaded
            uploader.bind('FileUploaded', function(up, file, response) {
                $('#' + file.id).fadeOut();
                //for(j in file)alert(j)
                response=response["response"];
                var fname="";
				var short_fname = "";
                if(imgId== imgId){
                    //send request to move file               
                    jQuery.post(ajaxurl,
                    {
                      action:"moveuploadprevfile",
                      fileurl:response  
                    },function(res){
                      fname=res;  						var args_fname = fname.split('/');                       var short_fname = args_fname[args_fname.length-1];
					  /*short_fname = fname.substring(17); */
                      jQuery('#adpcon_'+imgId).append("<li id='li_"+imgId+"_"+file.id+"'><div id='"+file.id+"' style='float:left;padding:5px;' class='adp'><input type='hidden' id='in_"+file.id+"' name='"+imgId+"["+imgId+"][]' value='"+fname+"' /><nobr><b><img style='position:absolute;z-index:9;cursor:pointer;' id='del_"+file.id+"' src='"+pluginurl+"images/remove.png' rel='li_"+imgId+"_"+file.id+"' class='del_adp' align=left /><img src='"+pluginurl+"libs/timthumb.php?w=50&h=50&zc=1&src="+fname+"'/></b></nobr><br/>"+short_fname+"<div style='clear:both'></div></div></li>");
                    });
                    
                }
                if(imgId=="img2"){
                    //send request to move file               
                    jQuery.post(ajaxurl,
                    {
                      action:"moveuploadprofile",
                      fileurl:response  
                    },function(res){
                        
                      fname=res;						var args_fname = fname.split('/');
                       var nm = args_fname[args_fname.length-1];					
                       /* if(fname.length>20) nm = fname.substring(0,7)+'...'+fname.substring(fname.length-10);*/
                        jQuery('#currentfiles').html("<div id='"+file.id+"' style='display:none' class='cfile'><input type='hidden' id='in_"+file.id+"' name='"+imgId+"[file]' value='"+fname+"' /><nobr><b><img id='del_"+file.id+"' src='"+pluginurl+"/images/remove.png' rel='del'  align=left />&nbsp;"+nm+"</b></nobr><div style='clear:both'></div></div>");
                        jQuery('#'+file.id).fadeIn();
                        jQuery('#del_'+file.id).click(function(){
                            if(jQuery(this).attr('rel')=='del'){
                            jQuery('#'+file.id).removeClass('cfile').addClass('dfile');
                            jQuery('#in_'+file.id).attr('name','del[]');
                            jQuery(this).attr('rel','undo').attr('src',pluginurl+'/images/add.png').attr('title','Undo Delete');
                            } else if(jQuery(this).attr('rel')=='undo'){
                            jQuery('#'+file.id).removeClass('dfile').addClass('cfile');
                            jQuery('#in_'+file.id).attr('name','files[]');
                            jQuery(this).attr('rel','del').attr('src',pluginurl+'/images/remove.png').attr('title','Delete File');
                            }
                        })
                          
                    });
                     ;
                }
                
            });
 
 
 
        });
    }
});
 
function plu_show_thumbs(imgId) {
    var $=jQuery;
    var thumbsC=$("#" + imgId + "plupload-thumbs");
    thumbsC.html("");
    // get urls
    var imagesS=$("#"+imgId).val();
    var images=imagesS.split(",");
    for(var i=0; i<images.length; i++) {
        if(images[i]) {
            var thumb=$('<div class="thumb" id="thumb' + imgId +  i + '"><img src="' + images[i] + '" alt="" /><div class="thumbi"><a id="thumbremovelink' + imgId + i + '" href="#">Remove</a></div> <div class="clear"></div></div>');
            thumbsC.append(thumb);
            thumb.find("a").click(function() {
                var ki=$(this).attr("id").replace("thumbremovelink" + imgId , "");
                ki=parseInt(ki);
                var kimages=[];
                imagesS=$("#"+imgId).val();
                images=imagesS.split(",");
                for(var j=0; j<images.length; j++) {
                    if(j != ki) {
                        kimages[kimages.length] = images[j];
                    }
                }
                $("#"+imgId).val(kimages.join());
                plu_show_thumbs(imgId);
                return false;
            });
        }
    }
    if(images.length > 1) {
        thumbsC.sortable({
            update: function(event, ui) {
                var kimages=[];
                thumbsC.find("img").each(function() {
                    kimages[kimages.length]=$(this).attr("src");
                    $("#"+imgId).val(kimages.join());
                    plu_show_thumbs(imgId);
                });
            }
        });
        thumbsC.disableSelection();
    }
}