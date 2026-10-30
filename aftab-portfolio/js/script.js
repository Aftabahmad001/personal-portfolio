document.addEventListener("DOMContentLoaded", () => {
  const t = document.querySelector(".nav-toggle"),
    n = document.querySelector(".primary-nav");
  if (t && n)
    t.addEventListener("click", () => {
      const e = n.classList.toggle("open");
      t.setAttribute("aria-expanded", String(e));
    });
  document.querySelectorAll(".filter-button").forEach((b) =>
    b.addEventListener("click", () => {
      document
        .querySelectorAll(".filter-button")
        .forEach((i) => i.classList.remove("active"));
      b.classList.add("active");
      const f = b.dataset.filter;
      document
        .querySelectorAll(".project-card")
        .forEach(
          (c) =>
            (c.hidden =
              f !== "all" && !c.dataset.category.split(" ").includes(f)),
        );
    }),
  );
  const top = document.querySelector(".back-to-top");
  if (top) {
    addEventListener(
      "scroll",
      () => top.classList.toggle("visible", scrollY > 400),
      { passive: true },
    );
    top.addEventListener("click", () =>
      scrollTo({ top: 0, behavior: "smooth" }),
    );
  }
  const els = document.querySelectorAll(".reveal");
  if (
    !matchMedia("(prefers-reduced-motion: reduce)").matches &&
    "IntersectionObserver" in window
  ) {
    const o = new IntersectionObserver(
      (es) =>
        es.forEach((e) => {
          if (e.isIntersecting) e.target.classList.add("is-visible");
        }),
      { threshold: 0.12 },
    );
    els.forEach((e) => o.observe(e));
  } else els.forEach((e) => e.classList.add("is-visible"));
});
