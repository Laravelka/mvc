@extends('layouts.base')

@section('title', ($http == 404 ? 'Страница не найдена' : 'Ошибка #'.$code))
@section('content')
    <div class=container>
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-10 col-lg-8">
                <div class="card theme card-body">
                    @isset($message)
                    @if ($http == 404)
                        <a href="/" class="btn theme btn-block">На главную</a>
                    @else
                    <pre class="pt-3 pb-3">
                        <code>
{{ $message }}
                        </code>
                    </pre>
                    @endif
                    @else
                        Проводятся технические работы.
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
