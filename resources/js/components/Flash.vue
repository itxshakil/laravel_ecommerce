<template>
  <div
    class="flash-alert border px-4 py-3 my-2 rounded w-64"
    :class="'bg-'+classes+'-100 text-'+classes+'-700 border-'+classes+'-400'"
    role="alert"
    v-show="show"
    v-text="body"
  ></div>
</template>

<script>
export default {
  props: ["message"],
  data() {
    return {
      body: this.message,
      level: "success",
      show: false
    };
  },
  created() {
    if (this.message) {
      this.flash();
    }
    window.events.$on("flash", data => this.flash(data));
  },
  computed: {
    classes() {
      if (this.level == "success") {
        return "green";
      }
      if (this.level == "danger") {
        return "red";
      }
      if (this.level == "warning") {
        return "yellow";
      }
    }
  },
  methods: {
    flash(data) {
      if (data) {
        this.body = data.message;
        this.level = data.level;
      }
      this.show = true;
      this.hide();
    },
    hide() {
      setTimeout(() => {
        this.show = false;
      }, 3000);
    }
  }
};
</script>
<style scoped>
.flash-alert {
  position: fixed;
  top: 30px;

  right: 30px;
}
</style>