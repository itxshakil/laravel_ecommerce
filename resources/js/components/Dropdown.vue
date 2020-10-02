<template>
  <div class="ml-3 relative" v-cloak>
    <button
      class="flex border-transparent focus:outline-none focus:border-white transition duration-150 ease-in-out"
      @click="active = !active"
    >
      <slot name="toggler"></slot>
    </button>
    <button
      v-if="active"
      @click="active = false"
      tabindex="-1"
      class="fixed top-0 inset-0 h-full w-full bg-black opacity-0 cursor-default"
    ></button>
    <div v-if="active" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg z-10">
      <slot name="items"></slot>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      active: false
    };
  }
};
</script>