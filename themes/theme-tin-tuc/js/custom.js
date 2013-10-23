jQuery(document).ready(function(){
													 
// ---------------------------------------------------------
// Tabs
// ---------------------------------------------------------
jQuery(".tabs").each(function(){

		jQuery(this).find(".tab").hide();
		jQuery(this).find(".tab-menu li:first a").addClass("active").show();
		jQuery(this).find(".tab:first").show();

});

jQuery(".tabs").each(function(){

		jQuery(this).find(".tab-menu a").click(function() {

				jQuery(this).parent().parent().find("a").removeClass("active");
				jQuery(this).addClass("active");
				jQuery(this).parent().parent().parent().parent().find(".tab").hide();
				var activeTab = jQuery(this).attr("href");
				jQuery(activeTab).fadeIn();
				return false;

		});

});


// ---------------------------------------------------------
// Toggle
// ---------------------------------------------------------

jQuery(".toggle").each(function(){

		jQuery(this).find(".box").hide();

});

jQuery(".toggle").each(function(){

		jQuery(this).find(".trigger").click(function() {

				jQuery(this).toggleClass("active").next().stop(true, true).slideToggle("normal");

				return false;

		});

});



jQuery(".recent-posts.team li:nth-child(4n), .recent-posts.clients li:nth-child(4n)").addClass("nomargin");

jQuery(".panel-wrapper .frame a").append("<span class='inner_border'></span>");



// ---------------------------------------------------------
// Social Icons
// ---------------------------------------------------------

jQuery(".social-networks li a").tooltip({ effect: 'slide', position: 'bottom center', opacity: .5 });

});