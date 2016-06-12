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
                        <a href="{{url('/cms/infos')}}" class="{{ Request::is('cms/infos') || Request::is('cms/infos/has_win') ? 'expand active-state' : '' }}"><i class="l-basic-folder"></i> <span class="txt">信息查看</span></a>
                        <ul class="sub {{ Request::is('cms/infos') || Request::is('cms/infos/1') ? ' show' : '' }}">
                            <li><a href="{{url('/cms/infos')}}" class="{{ Request::is('cms/infos') ? 'active' : '' }}"><span class="txt">图片</span></a></li>
                                <li><a href="{{url('/cms/infos',['type'=>1])}}" class="{{ Request::is('cms/infos/1') ? 'active' : '' }}"><span class="txt">视频</span></a></li>
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
