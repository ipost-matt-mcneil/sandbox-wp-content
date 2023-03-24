document.addEventListener('DOMContentLoaded', initializeTables);

function initializeTables() {
  const table = document.querySelectorAll('.table');

  console.log(table);

  if (table) {
    for (let i = 0; i < table.length; i += 1) { 
      const prev = table[i].querySelector('.table__prev--is-active');
      const next = table[i].querySelector('.table__next--is-active');
      const tableTable = table[i].querySelector('.table__table tbody');
      const tableTableColumns = tableTable.firstChild.childElementCount;
      if (tableTableColumns > 2) {
        if (prev) prev.addEventListener('click', changeTableColumn, false);
        if (next) next.addEventListener('click', changeTableColumn, false);
      } else {
        if (prev) prev.setAttribute('class', 'table__prev');
        if (next) next.setAttribute('class', 'table__next');
      }
    }
  }
  

  function changeTableColumn(evt) {
    evt.preventDefault(); 
    setTimeout(() => { 
      const direction = evt.target.getAttribute('class');
      const tableDiv = this.parentElement;
      const tableRows = tableDiv.querySelectorAll('.table__row');

      for (let i = 0; i < tableRows.length; i += 1) { 
        const tableCells = tableRows[i].querySelectorAll('.table__cell');
        const limit = tableCells.length - 1;
        for (let y = 0; y < tableCells.length; y += 1) {
          if (hasClass(tableCells[y], 'table__cell--is-active') && y <= limit) {
            if (direction === 'table__next table__next--is-active') {
              const first = tableCells[1];
              const next = tableCells[y].nextElementSibling;
              tableCells[y].setAttribute('class', 'table__cell table__cell--is-next-out');
              setTimeout(() => { 
                tableCells[y].setAttribute('class', 'table__cell');
              }, 500);
              if (y < limit) {
                next.setAttribute('class', 'table__cell table__cell--is-next-in table__cell--is-active');
              } else {
                first.setAttribute('class', 'table__cell table__cell--is-next-in table__cell--is-active');
              }
            } else {
              const last = tableCells[limit];
              const prev = tableCells[y].previousElementSibling;
              tableCells[y].setAttribute('class', 'table__cell table__cell--is-prev-out');
              setTimeout(() => { 
                tableCells[y].setAttribute('class', 'table__cell');
              }, 500);
              if (y === 1) {
                last.setAttribute('class', 'table__cell table__cell--is-prev-in table__cell--is-active');
              } else {
                prev.setAttribute('class', 'table__cell table__cell--is-prev-in table__cell--is-active');
              }
            }
            break;
          }
        }
      }
    }, 500);
    evt.preventDefault();
  }

  function hasClass(element, cls) {
    return (` ${element.className} `).indexOf(` ${cls} `) > -1;
  }
}

export default initializeTables;