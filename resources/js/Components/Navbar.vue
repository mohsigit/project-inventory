<template>
  <nav>
    <ul v-if="user.role === 'admin'">
      <li><a href="/inventories">Manage Inventories</a></li>
      <li><a href="/users">Manage Users</a></li>
    </ul>
    <ul v-else>
      <li><a href="/inventories">View Inventories</a></li>
      <li><a href="/inventories/request">Request Inventory</a></li>
    </ul>
  </nav>
</template>

<script>
export default {
  props: ['user'],
};
</script>
