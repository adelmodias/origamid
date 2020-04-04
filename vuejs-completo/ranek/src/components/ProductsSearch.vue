<template>
  <form>
    <input
      type="text"
      name="searchTerm"
      v-model="searchTerm"
      placeholder="Buscar..."
    />
    <input type="submit" value="Buscar" @click.prevent="searchProducts" />
  </form>
</template>

<script>
export default {
  data() {
    return {
      searchTerm: null
    };
  },
  methods: {
    searchProducts() {
      this.$router.push({
        query: { q: this.searchTerm }
      });
    }
  }
};
</script>

<style lang="scss" scoped>
form {
  max-width: 600px;
  margin: 30px auto 60px auto;
  position: relative;

  input {
    &[type="text"] {
      width: 100%;
      padding: 20px;
    }

    &[type="submit"] {
      width: 62px;
      height: 62px;
      background: url(../assets/search.svg) no-repeat center center;
      text-indent: -150px;
      border: none;
      cursor: pointer;
      position: absolute;
      top: 0;
      right: 0;
    }
  }
}
</style>
