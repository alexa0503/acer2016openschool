<aside id="sidebar" class="page-sidebar hidden-md hidden-sm hidden-xs">
    <!-- Start .sidebar-inner -->
    <div class="sidebar-inner">
        <!-- Start .sidebar-scrollarea -->
        <div class="sidebar-scrollarea">
            <!-- .side-nav -->
            <div class="side-nav">
                <ul class="nav">
                    <li>
                        <a href="{{url('/cms')}}" class="{{ Request::is('cms') ? 'active' : '' }}"><i class="l-basic-laptop"></i><span class="txt">Dashboard</span></a>
                    </li>
                    <li>
                        <a href="{{url('/cms/lotteries')}}" class="{{ Request::is('cms/lotteries') ? 'active' : '' }}"><i class="l-basic-laptop"></i><span class="txt">抽奖记录</span></a>
                    </li>
                    <li>
                        <a href="{{url('/cms/wechat')}}" class="{{ Request::is('cms/wechat') ? 'active' : '' }}"><i class="l-basic-laptop"></i><span class="txt">用户授权记录</span></a>
                    </li>
                    <li>
                        <a href="{{url('/cms/infos')}}" class="{{ Request::is('cms/infos') ? 'active' : '' }}"><i class="l-basic-laptop"></i><span class="txt">用户信息记录</span></a>
                    </li>
                    <li>
                        <a href="#" class="{{ Request::is('cms/prizes') || Request::is('cms/lottery/configs') || Request::is('cms/prize/configs') || Request::is('cms/prize/codes') ? 'expand active-state' : '' }}"><i class="l-basic-folder"></i> <span class="txt">奖品配置</span></a>
                        <ul class="sub {{ Request::is('cms/prizes') || Request::is('cms/lottery/configs') || Request::is('cms/prize/configs')  || Request::is('cms/prize/codes') ? ' show' : '' }}">
                            <li><a href="{{url('/cms/prizes')}}" class="{{ Request::is('cms/prizes') ? 'active' : '' }}"><span class="txt">奖品查看</span></a></li>
                            <li><a href="{{url('/cms/lottery/configs')}}" class="{{ Request::is('cms/lottery/configs') ? 'active' : '' }}"><span class="txt">时间段配置</span></a></li>
                            <li><a href="{{url('/cms/prize/configs')}}" class="{{ Request::is('cms/prize/configs') ? 'active' : '' }}"><span class="txt">奖品配置</span></a></li>
                            <li><a href="{{url('/cms/prize/codes')}}" class="{{ Request::is('cms/prize/codes') ? 'active' : '' }}"><span class="txt">奖券查看</span></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- / side-nav -->
        </div>
        <!-- End .sidebar-scrollarea -->
    </div>
    <!-- End .sidebar-inner -->
</aside>
