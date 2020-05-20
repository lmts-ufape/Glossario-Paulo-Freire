@extends('layouts.app')

@section('content')
@if(session('mensagem'))
    <div class="alert alert-success">
        <p>{{session('mensagem')}}</p>
    </div>
@endif
@if ($trecho->tipo_recurso == "áudio")
    <div class="row">
            <div class="col-sm-12" style="margin-bottom: 25px; margin-top: 25px;">
                <div style="margin-left: 12px;"><a style="font-size: 25px; font-family:arial;">@lang('mensagens.Editar trecho')</a></div>
            <div class="col-sm-12">
            @if ($errors->any())
                <div class="col-md-12" style="margin-top: 5px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="alert alert-danger" role="alert">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            </div>
                <ul class="list-group">
                        <li class="list-group-item div_container">
                        <form action="{{ Route('editar.update', ['id' => $trecho]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-5">
                                    <img src="{{ asset('imagens/imagem_audio.png') }}" alt="paper" style="width: auto; max-width: 100%;">
                                    @if ($trecho->arquivo_sd != '')
                                        <audio controls style="height: 35px; width: 425px;">
                                            <source src="{{ asset('storage/' . $trecho->arquivo_sd) }}" type="audio/mp3">
                                            <source src="{{ asset('storage/' . $trecho->arquivo_sd) }}" type="audio/flac">
                                            <source src="{{ asset('storage/' . $trecho->arquivo_sd) }}" type="audio/mp4">
                                            <source src="{{ asset('storage/' . $trecho->arquivo_sd) }}" type="audio/ogg">
                                        </audio> 
                                    @endif
                                    <br>
                                    @lang('mensagens.Arquivo de áudio'): </br>
                                    <input type="file" accept=".mp3,.mp4,.m4a,.ogg,.flac" name="arquivo_sd" id="arquivo"></input>
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col-sm-12" style="padding-top: 1rem;">
                                            <p>
                                                <span style="width: 100%; word-wrap: break-word;">@lang('mensagens.Texto'):</span>
                                                <textarea name="texto" rows="8" cols="90" style="width: 100%; word-wrap: break-word;">{{$trecho->texto}}</textarea>
                                            </p>
                                            <p>
                                                <span style="width: 100%; word-wrap: break-word;">@lang('mensagens.Titulo'):</span><br>
                                                <input name="titulo_video" type="text" size="50px" value="{{$trecho->titulo_video}}"></input>
                                            </p>
                                            <p>
                                                <span style="width: 100%; word-wrap: break-word;">@lang('mensagens.Tempo'):</span><br>
                                                <input name="tempo" type="text" size="50px" value="{{$trecho->tempo}}"></input>
                                            </p>
                                            <p>
                                                <span style="width: 100%; word-wrap: break-word;">@lang('mensagens.Link do áudio completo'):</span><br>
                                                <input name="endereco_video" type="text" size="50px" value="{{$trecho->endereco_video}}"></input>
                                            </p>
                                        </div>
                                        <div class="col-sm-12" style="padding: 1rem;">
                                            <button type="submit" class="btn" style="border-color:#d5d5d5; border-width:2px; height: 40px; background-color: white;"><label class="campo_compartilhar_texto">@lang('mensagens.Salvar')</label></button>
                                            <a href="javascript:history.back()"><button type="button" class="btn" style="border-color:#d5d5d5; border-width:2px; height: 40px; background-color: white;"><label class="campo_compartilhar_texto">@lang('mensagens.Cancelar')</label></button></a>                                   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </li>   
                </ul>
            </div>
    </div>
@else
    <div class="row">
            <div class="col-sm-12" style="margin-bottom: 25px; margin-top: 25px;">
                <div style="margin-left: 12px;"><a style="font-size: 25px; font-family:arial;">@lang('mensagens.Editar trecho')</a></div>
            </div>
            <div class="col-sm-12">
            @if ($errors->any())
                <div class="col-md-12" style="margin-top: 5px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="alert alert-danger" role="alert">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <ul class="list-group">
                    <li class="list-group-item div_container">
                        <form action="{{ Route('editar.update', ['id' => $trecho]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-5">
                                    @if ($trecho->arquivo_hd != '' || $trecho->arquivo_hd != '')
                                        <div id="videojs" style="height: 250px; max-width: 100%">
                                            <video id="my_video_{{ $trecho->id }}" class="video-js vjs-default-skin" onclick="contarView()" poster="{{ asset('imagens/imagem_video.png') }}" style="max-height: 100%; max-width: 100%" >
                                            </video>
                                            <script>
                                                videojs('my_video_{{ $trecho->id }}', {
                                                controls: true,
                                                    plugins: {
                                                        videoJsResolutionSwitcher: {
                                                            default: 'low', // Default resolution [{Number}, 'low', 'high'],
                                                            dynamicLabel: true,
                                                        }
                                                    }
                                                }, function(){
                                                    var player = this;
                                                    window.player = player
                                                        player.updateSrc([
                                                        {
                                                            src: "{{ asset('storage/' . $trecho->arquivo_sd) }}?SD",
                                                            type: 'video/mp4',
                                                            label: 'SD',
                                                            res: 360
                                                        },
                                                        {
                                                            src: "{{ asset('storage/' . $trecho->arquivo_sd) }}?SD",
                                                            type: 'video/webm',
                                                            label: 'SD',
                                                            res: 360
                                                        },
                                                        {
                                                            src: "{{ asset('storage/' . $trecho->arquivo_sd) }}?SD",
                                                            type: 'video/mkv',
                                                            label: 'SD',
                                                            res: 360
                                                        },
                                                        {
                                                            src: "{{ asset('storage/' . $trecho->arquivo_sd) }}?SD",
                                                            type: 'video/ogv',
                                                            label: 'SD',
                                                            res: 360
                                                        },
                                                        {
                                                            src: "{{ asset('storage/' . $trecho->arquivo_hd) }}?HD",
                                                            type: 'video/mp4',
                                                            label: 'HD',
                                                            res: 720
                                                        },
                                                        {
                                                            src: "{{ asset('storage/' . $trecho->arquivo_hd) }}?HD",
                                                            type: 'video/webm',
                                                            label: 'HD',
                                                            res: 720
                                                        },
                                                        {
                                                            src: "{{ asset('storage/' . $trecho->arquivo_hd) }}?HD",
                                                            type: 'video/mkv',
                                                            label: 'HD',
                                                            res: 720
                                                        },
                                                        {
                                                            src: "{{ asset('storage/' . $trecho->arquivo_hd) }}?HD",
                                                            type: 'video/ogv',
                                                            label: 'HD',
                                                            res: 720
                                                        },
                                                        ])
                                                    player.on('resolutionchange', function(){
                                                        console.info('Source changed to %s', player.src())
                                                    })
                                                })
                                            </script>
                                        </div>
                                    @else
                                        <img src="{{ asset('imagens/imagem_video.png') }}" alt="paper" style="width: auto; max-width: 100%">
                                    @endif
                                    <br>
                                    <p>
                                        @lang('mensagens.HD')</br>
                                        <input type="file" accept=".mp4,.mkv,.ogv,.webm" name="arquivo_hd" id="arquivo_hd"></input>
                                    </p>
                                    <p>
                                        @lang('mensagens.SD')</br>
                                        <input type="file" accept=".mp4,.mkv,.ogv,.webm" name="arquivo_sd" id="arquivo_sd"></input>
                                    </p>
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col-sm-12" style="padding-top: 1rem;">
                                            <p>
                                                <span style="width: 100%; word-wrap: break-word;">@lang('mensagens.Texto'):</span>
                                                <textarea name="texto" rows="8" cols="90" style="width: 100%; word-wrap: break-word;">{{$trecho->texto}}</textarea>
                                            </p>
                                            <p>
                                                <span style="width: 100%; word-wrap: break-word;">@lang('mensagens.Titulo'):</span><br>
                                                <input name="titulo_video" type="text" size="50px" value="{{$trecho->titulo_video}}"></input>
                                            </p>
                                            <p>
                                                <span style="width: 100%; word-wrap: break-word;">@lang('mensagens.Tempo'):</span><br>
                                                <input name="tempo" type="text" size="50px" value="{{$trecho->tempo}}"></input>
                                            </p>
                                            <p>
                                                <span style="width: 100%; word-wrap: break-word;">@lang('mensagens.Link do vídeo completo'):</span><br>
                                                <input name="endereco_video" type="text" size="50px" value="{{$trecho->endereco_video}}"></input>
                                            </p>
                                        </div>
                                        <div class="col-sm-12" style="padding: 1rem;">
                                            <button type="submit" class="btn" style="border-color:#d5d5d5; border-width:2px; height: 40px; background-color: white;"><label class="campo_compartilhar_texto">@lang('mensagens.Salvar')</label></button>
                                            <a href="javascript:history.back()"><button type="button" class="btn" style="border-color:#d5d5d5; border-width:2px; height: 40px; background-color: white;"><label class="campo_compartilhar_texto">@lang('mensagens.Cancelar')</label></button></a>                                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </li>
                </ul>
            </div>
    </div>
@endif
@endsection