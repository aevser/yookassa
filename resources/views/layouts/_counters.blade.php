@if ( !empty($yandexMetrika = $counters['yandexMetrika']) )
    @php
        $yandexMetrika = array_unique($yandexMetrika, SORT_REGULAR)
    @endphp
    @foreach($yandexMetrika as $count => $numCounter)
        <!-- Yandex.Metrika counter #{{ $count }}-->
        <script type="text/javascript" >
            (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
            (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

            ym({{ $numCounter }}, "init", {
                clickmap:true,
                trackLinks:true,
                accurateTrackBounce:true,
                webvisor:true
            });
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/{{ $numCounter }}" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->
    @endforeach
@endif

@if ( !empty($fb = $counters['facebook']) )
    @php
        $fb = array_unique($fb, SORT_REGULAR)
    @endphp
    @foreach($fb as $count => $numCounter)
        <!-- Facebook Pixel Code #{{ $count }}-->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $numCounter }}');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{ $numCounter }}&ev=PageView&noscript=1"/></noscript>
        <!-- End Facebook Pixel Code -->
    @endforeach
@endif

@if ( !empty($mailRu = $counters['mailRu']) )
    @php
        $mailRu = array_unique($mailRu, SORT_REGULAR)
    @endphp
    @foreach($mailRu as $count => $numCounter)
        <!-- Top.Mail.Ru counter -->
        <script type="text/javascript">
            var _tmr = window._tmr || (window._tmr = []);
            _tmr.push({id: "{{ $numCounter }}" , type: "pageView", start: (new Date()).getTime()});
            (function (d, w, id) {
                if (d.getElementById(id)) return;
                var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
                ts.src = "https://top-fwz1.mail.ru/js/code.js";
                var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
                if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
            })(document, window, "tmr-code");
        </script>
        <noscript><div><img src="https://top-fwz1.mail.ru/counter?id={{ $numCounter }};js=na" style="position:absolute;left:-9999px;" alt="Top.Mail.Ru" /></div></noscript>
        <!-- /Top.Mail.Ru counter -->
    @endforeach
@endif

@if ( !empty($mailTarget = $counters['mailTarget']) )
    @php
        $mailTarget = array_unique($mailTarget, SORT_REGULAR)
    @endphp
    @foreach($mailTarget as $count => $numCounter)
        <!-- Rating Mail.ru counter -->
        <script type="text/javascript">
        var _tmr = window._tmr || (window._tmr = []);
        _tmr.push({id: "{{ $numCounter }}", type: "pageView", start: (new Date()).getTime()});
        (function (d, w, id) {
          if (d.getElementById(id)) return;
          var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
          ts.src = "https://top-fwz1.mail.ru/js/code.js";
          var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
          if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
        })(document, window, "topmailru-code");
        </script><noscript><div>
        <img src="https://top-fwz1.mail.ru/counter?id={{ $numCounter }};js=na" style="border:0;position:absolute;left:-9999px;" alt="Top.Mail.Ru" />
        </div></noscript>
        <!-- //Rating Mail.ru counter -->
    @endforeach
@endif

<!-- /Callibri counter -->
<script src="//cdn.callibri.ru/callibri.js" type="text/javascript" charset="utf-8"></script>
