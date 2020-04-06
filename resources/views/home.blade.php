@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Dashboard</div>
        <img src="" alt="" id="img">
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  setInterval(async function () {
    document.querySelector('#img').src = 'http://192.168.92.252/backend/public/img/capture1.jpg?'+Date.now()
  }, 50);
</script>
@endsection
