<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-12 col-7">
                    <ul class="nav-sub-sx">
                        <li> <a class="{{ isset($active) == 'presentation' ? 'active' : '' }}"
                                href="{{ route('admin.home') }}">Dashboard</a> </li>
                        <li> <a href="https://creativouae.com/articles-and-newsletters/">Blog</a> </li>
                        <li> <a class="{{ isset($active) == 'presentation' ? 'active' : '' }}"
                                href="{{ route('admin.presentations') }}">Presentations</a> </li>
                        <li> <a class="{{ isset($active) == 'backend' ? 'active' : '' }}"
                                href="{{ route('admin.client') }}">Client Backend</a> </li>
                        <li> <a class="{{ isset($active) == 'website_domains' ? 'active' : '' }}"
                                href="{{ route('website.index') }}">Website & Domains</a> </li>
                        <li> <a class="{{ isset($active) == 'newsletter' ? 'active' : '' }}"
                                href="{{ route('newsletter.index') }}">Newsletter</a> </li>
                        <li> <a class="{{ isset($active) == 'tutorials' ? 'active' : '' }}"
                                href="{{ route('tutorial.index') }}">Tutorials</a> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-sub-sx>.active {
        background: #fff;
        padding: 6px;
        border-radius: 8px;
        color: #f26f24;
    }

</style>
