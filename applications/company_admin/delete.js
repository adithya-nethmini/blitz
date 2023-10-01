function deleteRow(button) {
    // Ask for confirmation before deleting the row
    if (confirm("Are you sure you want to delete this row?")) {
      // Traverse up the DOM to find the row element and remove it
      var row = button.parentNode.parentNode;
      row.parentNode.removeChild(row);
    }
  }
  