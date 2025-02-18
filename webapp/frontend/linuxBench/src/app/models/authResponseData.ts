export interface AuthResponseData {
  action:string,
  username:string|null,
  email:string,
  password:string,
  token:string,
  error:string,
  message:string,
  data:any,
  created_at:any,
  status:number,
}
