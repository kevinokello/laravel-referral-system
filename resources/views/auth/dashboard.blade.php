@extends('masters.master')
@section('content')

<div class="wrapper d-flex align-items-stretch">
   @include('auth.layout')
    <div id="content" class="p-4 p-md-5 pt-5">
        @if(session()->has('success'))
            <div class="alert alert-success my-2">
                <a href="" class="close" data-dismiss="alert">&times;</a>
                {{ session()->get('success') }}
            </div>
        @endif
        <div>
            <div>
                <h6>Share Link</h6>{!! $sharecomponents !!}
            </div>
            <h6 style="cursor: pointer;" class="copy" data-code="{{ Auth::user()->referral_code }}"><span class="fa 
            fa-copy mr-1"></span> Copy Referral</h6>
            <h4 class="mb-4" style="float: left;">Dashboad</h4>
            <h4 class="mb-4" style="float: right;">{{ $userpoints*10 }} Points</h4>
        </div><br>
        <hr style="border: 1px solid lightgray;">
        
        <div class="table-responsive">
            
            <table class="table table-bordered table-sm" id="Child_table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Verified</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($childuserfromparents) > 0)
                        @php $x = 1 @endphp
                        @foreach($childuserfromparents as $childuser)
                        <tr>
                            <td>{{ $x++ }}</td>
                            <td>{{ $childuser->user->name }}</td>
                            <td>{{ $childuser->user->email }}</td>
                            <td>
                                @if($childuser->user->is_verified == 0)
                                    <span class="badge badge-pill badge-danger">Un verified</span>
                                @else
                                    <span class="badge badge-pill badge-success">Verified</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    div#social-links ul li{
        display: inline-block;
    }
    div#social-links ul li a{
        padding: 10px;
        border: 1px solid #ccc;
        margin: 1px;
        /* font-size: px; */
        color: #222;
        background-color: #ccc;
    }
</style>
<script>
    $(document).ready(function(){
        $('#Child_table').DataTable();

        $('.copy').click(function(){
            $(this).parent().prepend('<span class="copied_text text-success"><b>Copied</b></span>');
            var code = $(this).attr('data-code');
            var url = "{{ URL::to('/') }}/referral-register?refe="+code;

            var temp = $("<input>");
            $('body').append(temp);
            temp.val(url).select();
            document.execCommand('copy');
            temp.remove();

            setTimeout(() => {
                $('.copied_text').remove();
            }, 2000);
        })

        $('.trash_account').click(function(){
            $.ajax({
                url: "{{ route('delete.account') }}",
                type : "GET",
                success: function(result){
                    if (result.success) {
                        location.reload();
                    }else{
                        alert(result.success);
                    }
                }
            })
        })
    })
</script>
@endsection