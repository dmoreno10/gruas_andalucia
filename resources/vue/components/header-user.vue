<template>
  <div>
    <li>
    <div class="user-box">
        <div class="avatar-lg">
<!--
            @if (Auth::check() && $user->profile_image)
            <a href="">
              <img src=""  class="avatar-img rounded-circle" alt="User Image">
            </a>
              @else
             <img src="{{ Vite::asset('resources/dist/img/jm_denis.jpg') }}" alt="Imagen predeterminada" class="avatar-img rounded-circle" />
            @endif -->
        </div>
        <div class="u-text">
            <!-- <h4  id="user"  class="user_profile_name" > {{ (Auth::user())?(Auth::user()->name):('invitado') }}</h4>
            <p  id="user" class="user_email"  class="text-muted">{{ (Auth::user())?(Auth::user()->email):('') }}</p> -->
            <a href="{{route('users.profile')}}"
                class="btn btn-xs btn-secondary btn-sm">View Profile</a>
        </div>
    </div>
</li>

  </div>
</template>

<script>
export default {
  name: 'ComponentName',
  data() {
    return {

    }
  },
  methods: {
    getUserData(){

    }
  }
}
</script>

<style scoped>
</style>


