import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {AuthResponseData} from '../models/authResponseData';
import {Observable, of, tap} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor(private http:HttpClient) {}

  public register(action:string, name:string, email:string, password:string) {
    return this.http.post<AuthResponseData>('http://localhost/auth_user.php', {
      action:action,
      username:name,
      email:email,
      password:password,
    })
  }

  public login(action:string, username:null, email:string, password:string) {
    return this.http.post<AuthResponseData>('http://localhost/auth_user.php', {
      action:action,
      username:username,
      email:email,
      password:password
    }).pipe(tap((response)=>{
      localStorage.setItem('token', response.token);
    }));
  }

  public loadData(username:string) {
    /*
    Load user profile data
     */
    return this.http.get<AuthResponseData>('http://localhost/auth_user.php?username='+username, {})
  }

  public authorize(token:string) {
    let headers = new HttpHeaders({
      'Accept': 'application/json',
      'Authorization': token
    })

    let options = {headers: headers};

    return this.http.post<AuthResponseData>(
      'http://localhost/auth_access.php',
      null,
      options
    );
  }

  public deleteStorage():Observable<void>{
    localStorage.removeItem('token');
    localStorage.removeItem('email');
    localStorage.removeItem('name');
    localStorage.removeItem('date');
    return of();
  }
}
