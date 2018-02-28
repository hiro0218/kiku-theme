export const wait = (TIMER = 200) => {
  return new Promise(resolve => {
    setTimeout(() => {
      resolve(true);
    }, TIMER);
  });
};
