<template>
  <div>
    <li>
    <div class="user-box">
        <div class="avatar-lg">
        </div>
        <div class="u-text">
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


