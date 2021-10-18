export default function groupBy<T extends object>(arr: T[], key: keyof T): Response<T> {
    return arr.reduce(function(rv, x) {
      (rv[x[key]] = rv[x[key]] || []).push(x);
      return rv;
    }, {} as any)
}

interface Response<T extends object> {
    [key: string]: T[]
}