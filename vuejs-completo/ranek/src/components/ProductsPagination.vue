<template>
  <div>
    <p>totalProducts: {{totalProducts}} -- productsPerpage {{productsPerpage}}</p>
    <ul>
      <li>
        <router-link :to="{query: {_page: 1}}">1</router-link>
      </li>
      <li>
        <router-link :to="{query: {_page: 2}}">2</router-link>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "ProductsPagination",
  props: {
    totalProducts: {
      type: Number,
      default: 1
    },
    productsPerpage: {
      type: Number,
      default: 1
    }
  }
};
</script>