document.addEventListener('DOMContentLoaded', function () {
  const carouselList = document.querySelector('.carousel__list');
  const carouselItems = document.querySelectorAll('.carousel__item');
  const elems = Array.from(carouselItems);

  // Event listener for click on the carousel
  carouselList.addEventListener('click', function (event) {
    const newActive = event.target;
    const isItem = newActive.closest('.carousel__item');

    if (!isItem || newActive.classList.contains('carousel__item_active')) {
      return;  // Ignore clicks on the active item
    }

    update(newActive);  // Update carousel when a new item is clicked
  });

  // Update positions of the carousel items based on the clicked item
  function update(newActive) {
    const newActivePos = newActive.dataset.pos;

    // Get references to the carousel items based on their position
    const current = elems.find((elem) => elem.dataset.pos == 0);
    const prev = elems.find((elem) => elem.dataset.pos == -1);
    const next = elems.find((elem) => elem.dataset.pos == 1);
    const first = elems.find((elem) => elem.dataset.pos == -2);
    const last = elems.find((elem) => elem.dataset.pos == 2);

    // Remove the 'carousel__item_active' class from the current item
    current.classList.remove('carousel__item_active');

    // Update positions for all items
    [current, prev, next, first, last].forEach(item => {
      const itemPos = item.dataset.pos;
      item.dataset.pos = getPos(itemPos, newActivePos);
    });

    // Add the 'carousel__item_active' class to the clicked item
    newActive.classList.add('carousel__item_active');
  }

  // Get the new position of an item based on the clicked item's position
  function getPos(current, active) {
    const diff = current - active;

    // Wrap around positions when moving far enough
    if (Math.abs(current - active) > 2) {
      return -current;
    }

    return diff;
  }
});
