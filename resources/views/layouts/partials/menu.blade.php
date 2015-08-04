<div class="Menu-list">
	<ul class="nav">
        <?php $menus = \Html::menu(); ?>
        @foreach ($menus as $menu)
            <li class="submenu {{ ($menu['currentRoute'] != "inicio") ? ( $menu['currentRoute'] == strtolower(substr($menu['url'],1)) ? "active" : "" ): "" }}">
                <a href="#">
                    @if($menu['icon_font'])
                        <span class="{{ $menu['icon_font'] }}"></span>
                    @else
                        <span class="fa fa-tag"></span>
                    @endif
                    <span class="Menu-option">{{ convertTitle($menu['name']) }}</span>
                    <span class="icon-menu glyphicon glyphicon-chevron-right pull-right"></span>
                </a>
                <ul class="nav" style='{{ ($menu['currentRoute'] != "inicio") ? ($menu['currentRoute'] == strtolower(substr($menu['url'],1)) ? "display:block" : "display:none" ) : "" }}'>
                    @foreach($menu['tasks'] as $task)
                        @if( strtolower($task['name']) != 'eliminar' && strtolower($task['name']) != 'editar')
                            <li class="{{ ($menu['currentRoute'] != "inicio") ? ( (Route::currentRouteName() == strtolower($task['name']).'-'.strtolower(substr($menu['url'],1))) ? "active-menu" : ""): "" }}">
                                <a href="{{ url(''.strtolower($menu['url']).'/'.strtolower($task['name'])) }}">{{$task['name']}}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
        @endforeach
	</ul>
</div>