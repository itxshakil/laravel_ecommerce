<template>
  <div class="mt-2 border rounded bg-gray-100 p-4">
    <div v-text="title"></div>
    <i class="fa fas- fa-star text-yellow-600 mr-1" v-for="star in parseInt(rating)"></i>
    <div class="mt-2" v-text="description"></div>
    <div>By-<span v-text="username" class="font-semibold"></span></div>
  </div>
</template>
<script>
export default {
  props: ["data"],
  data() {
    return {
      username: this.data.user.name,
      title: this.data.title,
      description: this.data.description,
      rating: this.data.rating
    };
  }
};
</script>