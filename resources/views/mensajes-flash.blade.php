@if ($message = Session::get('success'))
<div class="alert alert-success alert-block animated shake" >
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <h5>{{ $message }}</h5>
</div>
@endif
  
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block animated shake">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{ $message }}</strong>
</div>
@endif
   
@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block animated shake">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{ $message }}</strong>
</div>
@endif
   
@if ($message = Session::get('info'))
<div class="alert alert-info alert-block animated shake">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{ $message }}</strong>
</div>
@endif
  
@if ($errors->any())
<div class="alert alert-danger animated shake">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    @foreach($errors->all() as $error)
        <li><strong>{{$error}}</strong></li>
    @endforeach
</div>
@endif