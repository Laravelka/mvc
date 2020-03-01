@extends('layouts.base')

@section('title', 'Long Polling')
@section('content')
	<div class=container>
        <div class="row justify-content-center">
			<div class="col-sm-8 col-md-6 col-lg-5">
                <script type="text/javascript">
                    function poll() {
                        var ajax = new XMLHttpRequest();
                        ajax.onreadystatechange = function() {
                            if (this.readyState === 4 && this.status === 200) {
                                if (this.status === 200) {
                                    try {
                                        var json = JSON.parse(this.responseText);
                                    } catch {
                                        poll();return;
                                    }
                                    
                                    if (json.status !== true)
                                    {
                                        console.error(json.error);
                                        return;
                                    }
                                    
                                    $('#logs').html('time: ' + json.time + ', content: ' + json.content);
                                    
                                    poll();
                                } else {
                                    poll();
                                }
                            }
                        }
                        ajax.open('GET', '/api/logs', true);
                        ajax.send();
                    }
                    
                    $(document).ready(function() {
                        poll();
                    });
                </script>
                <div id="logs" class="card theme card-body"></div>
            </div>
		</div>
	</div>
@endsection
