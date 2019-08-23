{!! Html::script('js/plugins.min.js') !!}
{!! Html::script('js/app.min.js') !!}
{!! Html::script('js/configurator.min.js') !!}
{!! Html::script('js/bootstrap.min.js') !!}

    <script>
      (function(i, s, o, g, r, a, m)
      {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function()
        {
          (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
          m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
      })(window, document, 'script', '../../../../www.google-analytics.com/analytics.js', 'ga');
      ga('create', 'UA-90917746-2', 'auto');
      ga('send', 'pageview');
    </script>
@stack('scripts')
