<div class="Menu-list">
	<ul class="nav">
        <?php  $menus = \Html::menu(); ?>
        @foreach ($menus as $key => $menu)
            @if($key != 0)
            @if($menu['resource'])
                <li class="{{ ($menu['resource']) ? '' : 'submenu' }} {{ ($menus[0] != "inicio") ? ( $menus[0] == strtolower(substr($menu['url'],1)) ? "active" : "" ): "" }}">
            @else
                <li class="{{ ($menu['resource']) ? '' : 'submenu' }} {{ ($menus[0] != "inicio") ? ( $menus[0] == strtolower(substr($menu['url'],1)) ? "active" : "" ): "" }}">
            @endif
                <a href="/{{ ($menu['resource']) ? strtolower($menu['name']) : "#" }}">
                    @if($menu['icon_font'])
                        <span class="{{ $menu['icon_font'] }}"></span>
                    @else
                        <span class="fa fa-tag"></span>
                    @endif
                    <span class="Menu-option">{{ convertTitle($menu['name']) }}</span>
                    @if(!$menu['resource'])
                        <span class="icon-menu glyphicon glyphicon-chevron-right pull-right"></span>
                    @endif
                </a>
                @if(!$menu['resource'])
                <ul class="nav" style='{{ ($menus[0] != "inicio") ? ($menus[0] == strtolower(substr($menu['url'],1)) ? "display:block" : "display:none" ) : "" }}'>
                    @foreach($menu['tasks'] as $task)
                        @if( strtolower($task['name']) != 'eliminar' && strtolower($task['name']) != 'editar')
                            <li class="{{ ($menus[0] != "inicio") ? ( (Route::currentRouteName() == strtolower($task['name']).'-'.strtolower(substr($menu['url'],1))) ? "active-menu" : ""): "" }}">
                                <a href="{{ url(''.strtolower($menu['url']).'/'.strtolower($task['name'])) }}">{{$task['name']}}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
                @endif
            </li>
            @endif
        @endforeach
	</ul>
</div>