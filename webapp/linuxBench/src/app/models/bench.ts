export interface Bench {
  username:string,
  bench_name:string,
  bench_type:string,
  hw_model:string
  frequency:number,
  average:number,
  fastest:number,
  id:string|null,
  status:number|null,
  message:string|null
}
