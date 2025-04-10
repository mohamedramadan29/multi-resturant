  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
      <div class="main-menu-content">
          <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
              <li class="nav-item {{ Route::is('dashboard.welcome') ? 'active' : '' }}"><a
                      href="{{ route('dashboard.welcome') }}"><i class="la la-home"></i><span class="menu-title"
                          data-i18n="nav.dash.main">الرئيسية</span></a>
              </li>
              @can('superadmin')
                  <li class="nav-item {{ Route::is('dashboard.resturants.*') ? 'active' : '' }}"><a href="#"><i
                              class="la la-building"></i><span class="menu-title" data-i18n="nav.role.main"> المطاعم
                          </span></a>
                      <ul class="menu-content">
                          <li class="{{ Route::is('dashboard.resturants.index') ? 'active' : '' }}">
                              <a class="menu-item" href="{{ route('dashboard.resturants.index') }}"
                                  data-i18n="nav.role.index">
                                  جميع المطاعم </a>
                          </li>
                          <li class="{{ Route::is('dashboard.resturants.create') ? 'active' : '' }}">
                              <a class="menu-item" href="{{ route('dashboard.resturants.create') }}"
                                  data-i18n="nav.templates.vert.classic_menu"> <i class="la la-plus"></i> <span
                                      class="menu-title"> اضافة مطعم </a>
                          </li>
                      </ul>
                  </li>
              @endcan
              @can('superadmin')
                  <li class="nav-item{{ Route::is('dashboard.admins.*') ? 'active' : '' }}"><a href="#"><i
                              class="la la-users"></i><span class="menu-title" data-i18n="nav.users.main"> الادارين
                          </span></a>
                      <ul class="menu-content">
                          <li class="{{ Route::is('dashboard.admins.index') ? 'active' : '' }}">
                              <a class="menu-item" href="{{ route('dashboard.admins.index') }}"
                                  data-i18n="nav.users.user_profile"> الادارين
                              </a>
                          </li>

                          <li class="{{ Route::is('dashboard.admins.create') ? 'active' : '' }}">
                              <a class="menu-item" href="{{ route('dashboard.admins.create') }}"
                                  data-i18n="nav.users.user_cards"> اضافة اداري </a>
                          </li>
                      </ul>
                  </li>
              @endcan
              @can('admin')
                  <li class="nav-item{{ Route::is('dashboard.categories.*') ? 'active' : '' }}"><a href="#"><i
                              class="la la-list"></i><span class="menu-title" data-i18n="nav.users.main"> تصنيفات المنتجات
                          </span></a>
                      <ul class="menu-content">
                          <li class="{{ Route::is('dashboard.categories.index') ? 'active' : '' }}">
                              <a class="menu-item" href="{{ route('dashboard.categories.index') }}"
                                  data-i18n="nav.users.user_profile"> تصنيفات المنتجات
                              </a>
                          </li>

                          <li class="{{ Route::is('dashboard.categories.create') ? 'active' : '' }}">
                              <a class="menu-item" href="{{ route('dashboard.categories.create') }}"
                                  data-i18n="nav.users.user_cards"> اضافة تصنيف جديد </a>
                          </li>
                      </ul>
                  </li>
              @endcan
              @can('admin')
                  <li class="nav-item{{ Route::is('dashboard.products.*') ? 'active' : '' }}"><a href="#"><i
                              class="la la-list"></i><span class="menu-title" data-i18n="nav.users.main"> ادارة المنتجات
                          </span></a>
                      <ul class="menu-content">
                          <li class="{{ Route::is('dashboard.products.index') ? 'active' : '' }}">
                              <a class="menu-item" href="{{ route('dashboard.products.index') }}"
                                  data-i18n="nav.users.user_profile"> المنتجات
                              </a>
                          </li>

                          <li class="{{ Route::is('dashboard.products.create') ? 'active' : '' }}">
                              <a class="menu-item" href="{{ route('dashboard.products.create') }}"
                                  data-i18n="nav.users.user_cards"> اضافة منتج جديد </a>
                          </li>
                      </ul>
                  </li>
              @endcan
              @can('admin')
                  <li class="nav-item{{ Route::is('dashboard.orders.*') ? 'active' : '' }}"><a href="#"><i
                              class="la la-list"></i><span class="menu-title" data-i18n="nav.users.main"> ادارة الطلبات
                          </span></a>
                      <ul class="menu-content">
                          <li class="{{ Route::is('dashboard.orders.index') ? 'active' : '' }}">
                              <a class="menu-item" href="{{ route('dashboard.orders.index') }}"
                                  data-i18n="nav.users.user_profile"> الطلبات
                              </a>
                          </li>
                      </ul>
                  </li>
              @endcan
              @can('roles')
                  <li class="nav-item {{ Route::is('dashboard.roles.*') ? 'active' : '' }}"><a href="#"><i
                              class="la la-television"></i><span class="menu-title" data-i18n="nav.role.main"> الصلاحيات
                          </span></a>
                      <ul class="menu-content">
                          <li class="{{ Route::is('dashboard.roles.index') ? 'active' : '' }}">
                              <a class="menu-item" href="{{ route('dashboard.roles.index') }}" data-i18n="nav.role.index">
                                  جميع الصلاحيات </a>
                          </li>
                          <li class="{{ Route::is('dashboard.roles.create') ? 'active' : '' }}">
                              <a class="menu-item" href="{{ route('dashboard.roles.create') }}"
                                  data-i18n="nav.templates.vert.classic_menu"> <i class="la la-plus"></i> <span
                                      class="menu-title""> اضافة صلاحية </a>
                          </li>
                      </ul>
                  </li>
              @endcan

              <li class="nav-item {{ Route::is('dashboard.update_profile.*') ? 'active' : '' }}"><a href="#"><i
                          class="la la-user"></i><span class="menu-title" data-i18n="nav.users.main"> ادارة
                          حسابي
                      </span></a>
                  <ul class="menu-content">
                      <li class="{{ Route::is('dashboard.update_profile') ? 'active' : '' }}">
                          <a class="menu-item" href="{{ route('dashboard.update_profile') }}"
                              data-i18n="nav.users.user_profile"> تعديل البيانات
                          </a>
                      </li>
                      <li class="{{ Route::is('dashboard.update_password') ? 'active' : '' }}">
                          <a class="menu-item" href="{{ route('dashboard.update_password') }}"
                              data-i18n="nav.users.user_profile"> تعديل كلمة المرور
                          </a>
                      </li>
                  </ul>
              </li>

              @can('setting')
                  <li class="nav-item{{ Route::is('dashboard.settings.*') ? 'active' : '' }}"><a href="#"><i
                              class="la la-list"></i><span class="menu-title" data-i18n="nav.users.main"> الاعدادات
                              العامة
                          </span></a>
                      <ul class="menu-content">
                          <li class="{{ Route::is('dashboard.settings.update') ? 'active' : '' }}">
                              <a class="menu-item" href="{{ route('dashboard.settings.update') }}"
                                  data-i18n="nav.users.user_profile"> الاعدادات العامة
                              </a>
                          </li>

                          @can('superadmin')


                          <li class="{{ Route::is('dashboard.settings.upload.video') ? 'active' : '' }}">
                              <a class="menu-item" href="{{ route('dashboard.settings.upload.video') }}"
                                  data-i18n="nav.users.user_profile"> رفع الفيديو
                              </a>
                          </li>
                      @endcan

                  </ul>
              </li>
          @endcan

      </ul>
  </div>
</div>
