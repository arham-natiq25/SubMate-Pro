<template>
    <Header/>

    <Sidebar/>

     <slot>

     </slot>

      <Footer/>

  </template>

  <script>
  import Header from '../layouts/Header.vue';
  import Sidebar from '../layouts/Sidebar.vue';
  import Footer from '../layouts/Footer.vue';
  export default {
      components:{
          Header,
          Sidebar,
          Footer
      }
  }
  </script>
