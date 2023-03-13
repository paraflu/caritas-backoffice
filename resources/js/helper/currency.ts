export const currency = (data: number) => Intl.NumberFormat("it-IT", { style: 'currency', currency: 'EUR' }).format(data);
