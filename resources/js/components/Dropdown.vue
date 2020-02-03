<template>
  <div class="relative" v-cloak>
    <button
      class="relative z-10 overflow-hidden focus:outline-none cursor-pointer"
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
    <div
      v-if="active"
      class="absolute align-middle top-auto left-0 mr-12 mt-2 mx-2 rounded-lg border-gray-900 shadow-xl"
    >
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