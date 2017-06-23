<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>

<script>
(function() {
  'use strict';
  var snackbarContainer = document.querySelector('#demo-toast-example');
  
  var handler = function(event) {
    
  };
  
  $(window).on('load', function() {
    'use strict';
    var data = {
      message: '<?php echo $msg; ?>',
      timeout: 2000,
      actionHandler: handler,
      actionText: 'Okay'
    };
    snackbarContainer.MaterialSnackbar.showSnackbar(data);
  });
}());
</script>