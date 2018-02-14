 $(document).ready(function () {
            $("ul[id*=myid] li").click(function () {
                //alert($(this).html()); // gets innerHTML of clicked li
               // alert($(this).text()); // gets text contents of clicked li
                var cat = $(this).text();
          	   $.post('include_ajax.php', {cat: cat}, function(data){
           		$('div#maincontent').html(data);
                 });
            });
        });

/*
 $.ajax({
     type:"POST",
     url: "include_ajax.php",
     data: json,
     success: function(data) {
         document.write("<pre>" + data);
     }
 });
 */