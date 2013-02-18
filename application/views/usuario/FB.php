<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <script type="text/javascript"> 

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-23173661-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
          
            _gaq.push(["_setCustomVar", "1" ,"login", "user_<?php echo $id_usuario; ?>"], '1');
            _gaq.push(['_trackEvent', 'login', 'FACEBOOK']); 
            _gaq.push(['_deleteCustomVar', 1]);
            top.location = "<?php echo base_url();?>usuario";

        </script>
    </head>
</html>