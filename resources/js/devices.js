$(document).ready(function (){
   $('#deviceTable tr[data-deviceid]').click(function (){
     window.location = _dir + "/devices/" + this.getAttribute("data-deviceid");
   });
   $('#deviceTable button.link-danger').click(function (e){
       e.stopPropagation();
   });
});
