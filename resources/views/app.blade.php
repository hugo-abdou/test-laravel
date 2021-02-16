@extends('layouts.app')

@section('content')
@inertia
<!-- Scripts -->
<script src="{{ asset(mix('js/app.js')) }}"></script>
<script id="__bs_script__">
    //<![CDATA[
    document.write("<script async src='http://HOST/browser-sync/browser-sync-client.js?v=2.26.13'><\/script>".replace("HOST", location.hostname));
    //]]>
</script>
@endsection