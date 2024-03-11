<script>
    function jsSearchTable()
    {
        var found, td, i, j;
        var input = document.getElementById("search");
        var filter = input.value.toUpperCase();
        var table = document.getElementById("<?= user() ?>");
        var tr = table.querySelectorAll("tbody tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td");
            for (j = 0; j < td.length; j++) {
                if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                }
            }
            if (found) {
                tr[i].style.display = "";
                found = false;
            } else {
                tr[i].style.display = "none";
            }
        }
    }

    var url = new URL(window.location.href);
    var action = url.searchParams.get('action');
    var code = url.searchParams.get('code');
    
    if(action == 'my-module' && code)
    {

        if (code) {
            var Timer = setInterval(lapse, 1000);
            
            function lapse(){
                
                var time = document.getElementById("time-remaining");
                var hours = document.getElementById("h");
                var minutes = document.getElementById("m");
                var seconds = document.getElementById("s");
                var h = hours.innerHTML;
                var m = minutes.innerHTML;
                var s = seconds.innerHTML;

                if(s == 0 && m > 0 && h > 0)
                {
                    s = 60;
                    m = m - 1;
                }

                if(m == 0 && h > 0)
                {
                    m = 59;
                    h = h - 1;
                }
                
                if (h == '00' && m == '00' && s == '00') {
                    clearInterval(Timer)
                    return;
                }

                function timeLapse(h, m, s)
                {

                    h = h.toString();
                    m = m.toString();
                    s = s.toString();

                    if (s > 0) {

                        var s = s - 1;
                    
                    }
                    
                    if (s < 10) {
                        s = '0' + String(s);
                    }

                    if(m < 10)
                    {
                        m = '0' + String(m);
                    }

                    hours.innerHTML = h;
                    minutes.innerHTML = m;
                    seconds.innerHTML = s;
                    
                }

                timeLapse(h, m, s)

            };
        }
        
    }
</script>

  </body>
</html>