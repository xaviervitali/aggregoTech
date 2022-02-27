const color = [0, 0, 255];
document
  .querySelectorAll(".nav-item")
  .forEach(
    (e, i) =>
      (e.style =
        "background: rgba(" +
        color.slice(0, 2).join(",") +
        "," +
        color[2] -
        i * 10 +
        ", .5);")
  );
