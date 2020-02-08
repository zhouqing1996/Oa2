<template>
  <div>
    <keep-alive>
      <router-view :key="key"></router-view>
    </keep-alive>
  </div>
</template>

<script>
    export default {
        data(){
            return{

            }
        },
        computed:{
            key(){
                return this.$route.path + Math.random();
            }
        }
    }
</script>

<style scoped>

</style>
