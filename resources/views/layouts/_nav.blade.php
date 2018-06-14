<header>
    @if(auth()->check())
        <navigation :auth-user="{{ auth()->user() }}" v-cloak inline-template>
    @else
        <navigation v-cloak inline-template>
    @endif
        <div class="container">
            <div class="header-top">
                <h1>Forum</h1>
                @if(auth()->check())
                    <div class="image">
                         <img class="home-image" src="{{ asset(auth()->user()->avatar_path) }}">
                        <a class="user" href="{{ auth()->user()->path() }}">{{ auth()->user()->name }}</a>
                    </div>
                   
                @else
                    <a href="#" @click.prevent="show">Login</a>
                    <login></login>
                @endif
            </div>
            <nav>
                <a href="/">Home</a>
                <a href="/questions">Answer</a>
                <a href="/search">Search</a>
                <a href="/topics">Topic</a>
                @if(auth()->check())
                <!-- notification -->
                    <a class="dropdown" @click.self="showNotification" v-if="notifications.length">
                        Notification
                         <notification :auth-user="{{ auth()->user() }}" :notifications="this.notifications" v-if="notify"></notification>
                         <span class="badge" v-text="notifications.length"></span>
                    </a>
                   
                <!-- logout -->
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endif
            </nav>
        </div>
    </navigation>
</header>