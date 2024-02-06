<script setup lang="ts">

</script>

<template>
  <div class="controls-block">
    <div class="form-control">
        <label for="count" class="form-label">Count</label>
        <input class="form-control" min="1" step="1" type="number" id="count">
    </div>
    <div class="form-control">
        <label for="offset" class="form-label">Offset</label>
        <input class="form-control" min="1" step="1" type="number" id="offset">
    </div>
    <div class="form-control">
      <label for="page" class="form-label">Page</label>
      <input class="form-control" type="number" min="1" step="1" id="page">
    </div>
  </div>
  <table class="table">
    <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Larry</td>
      <td>the Bird</td>
      <td>@twitter</td>
    </tr>
    </tbody>
  </table>

  <table class="table">
    <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Larry</td>
      <td>the Bird</td>
      <td>@twitter</td>
    </tr>
    </tbody>
  </table>
  <div class="pagination-block">
    <button type="button" class="btn btn-info">Info</button>
    <nav aria-label="...">
      <ul class="pagination">
        <li class="page-item disabled">
          <a class="page-link" href="#" tabindex="-1">Previous</a>
        </li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item active">
          <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
        </li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
          <a class="page-link" href="#">Next</a>
        </li>
      </ul>
    </nav>
  </div>

</template>

<style scoped>
.pagination-block,
.controls-block {
  display: flex;
  justify-content: space-around;
}
</style>