</div>
</div>
<br>
<br>

<!-- right side bar -->


<footer class="text-center" id="footer">&copy; Copyright 2018 </footer>












<script>
function get_child_options(){
var parentID =  jQuery('#parent').val();
jQuery.ajax({
    url:'/tutorial/admin/parsers/child_categories.php',
    type:'POST',
    data:{parentID:parentID},
    success: function(data){
        jQuery('#child').html(data);
    },
    error: function(){alert("something went wrong with the child options")},
});
}
    jQuery('select[name="parent"]').change(get_child_options);


</script>


</body>

</html>
