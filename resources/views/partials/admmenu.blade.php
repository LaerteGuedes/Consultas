<div class="menu">
    <div class="panel panel-default">
        <div class="panel-body">
            <p>Página inicial</p>
            <ul class="menu-itens">
                <li><a href="{{route('adm.dashboard')}}">Home</a></li>
            </ul>
            <p>Usuários</p>
            <ul class="menu-itens">
                <li><a href="{{route('adm.usuarios')}}">Usuários</a></li>
            </ul>
            <p>Profissionais</p>
            <ul class="menu-itens">
                <li><a href="{{route('adm.profissionais')}}">Profissionais</a></li>
                <li><a href="{{route('adm.especialidades')}}">Tipos e Especialidades</a></li>
            </ul>
            <p>Configurações do aplicativo</p>
            <ul class="menu-itens">
                <li><a href="{{route('adm.bairros')}}">Bairros</a></li>
                <li><a href="{{route('adm.assinaturas')}}">Pacotes de assinatura</a></li>
                <li><a href="{{route('adm.operadoras')}}">Planos de Saúde</a></li>
            </ul>
        </div>
    </div>
</div>