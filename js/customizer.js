(function($){
    wp.customize('muhtawaa_primary_color', function(value){
        value.bind(function(newval){
            document.documentElement.style.setProperty('--primary-color', newval);
        });
    });
    wp.customize('muhtawaa_text_color', function(value){
        value.bind(function(newval){
            document.documentElement.style.setProperty('--text-color', newval);
        });
    });
    wp.customize('muhtawaa_secondary_bg_color', function(value){
        value.bind(function(newval){
            document.documentElement.style.setProperty('--secondary-color', newval);
        });
    });

    wp.customize('muhtawaa_progress_color', function(value){
        value.bind(function(newval){
            document.documentElement.style.setProperty('--progress-color', newval);
        });
    });

    wp.customize('muhtawaa_progress_height', function(value){
        value.bind(function(newval){
            document.documentElement.style.setProperty('--progress-height', newval + 'px');
        });
    });
})(jQuery);
