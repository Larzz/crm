<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-12 col-7">
                    <ul class="nav-sub-sx">
                        <li> <a class="{{ $active === 'dashboard' ? 'active' : '' }}"
                                href="{{ route('admin.home') }}">Dashboard</a> </li>
                        <li> <a href="https://creativouae.com/articles-and-newsletters/">Blog</a> </li>
                        <li> <a class="{{ $active === 'presentation' ? 'active' : '' }}"
                                href="{{ route('admin.presentations') }}">Presentations</a> </li>
                        <li> <a class="{{ $active === 'backend' ? 'active' : '' }}"
                                href="{{ route('admin.client') }}">Client Backend</a> </li>
                        <li> <a class="{{ $active === 'website_domains' ? 'active' : '' }}"
                                href="{{ route('website.index') }}">Website & Domains</a> </li>
                        <li> <a class="{{ $active === 'newsletter' ? 'active' : '' }}"
                                href="{{ route('newsletter.index') }}">Newsletter</a> </li>
                        <li> <a class="{{ $active === 'tutorials' ? 'active' : '' }}"
                                href="{{ route('tutorial.index') }}">Tutorials</a> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
