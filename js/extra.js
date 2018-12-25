
// Close error. Use jQuery slide if available.
window.onload = function() {
    if (window.jQuery) {
        $("#closeError").click(function(){
            $("#errorContainer").slideToggle(200);
        });
    }else{
        document.getElementById('closeError').onclick = function() {
            document.getElementById('errorContainer').setAttribute("style", "display:none");
        }
    }
}