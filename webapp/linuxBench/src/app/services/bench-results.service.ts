import {EventEmitter, Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Bench} from '../models/bench';
import {map, tap} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class BenchResultsService {

  private benches:Bench[] = [];
  public onResultCountChange = new EventEmitter();
  public idToken:string = "";

  constructor(private http:HttpClient) {
    let tmp = localStorage.getItem('token');
    if (tmp != null) {
      this.idToken = tmp;
    }
  }

  public addResult(item:Bench) {
    /*
    Add result
     */
    return this.http.post("http://localhost/crud.php", item, {})
  }

  public benchResults(bench:string){
    /*
    Load results for a given benchmark
     */
    return this.http
      .get<{[key:string]:Bench}>("http://localhost/crud.php?benchmark="+bench, {})
      .pipe(
        map((data):Bench[]=>{
          const benches = [];
          for (let k in data){
            benches.push(data[k]);
          }
          return benches;
        }),
        tap((data)=>{
          this.benches = data;
          this.onResultCountChange.emit();
        })
      )
  }

  public userResults(bench_name:string, username:string) {
    /*
    Collect results uploaded by the given user
     */
    return this.http
      .get<{[key:string]:Bench}>("http://localhost/crud.php?benchmark="+bench_name+"&username="+username, {})
  }

  public loadResult(benchmark:string, id:string){
    /*
    Load single result of a given benchmark to edit
     */
    return this.http
      .get<{[key:string]:Bench}>("http://localhost/crud.php?benchmark="+benchmark+"&id="+id, {})
      .pipe(
        map((data):Bench[]=>{
          const benches = [];
          for (let k in data){
            benches.push(data[k]);
          }
          return benches;
        }),
        tap((data)=>{
          this.benches = data;
          this.onResultCountChange.emit();
        })
      )
  }
  public updateRecord(item:Bench){
    /*
    Update a record
     */
    return this.http.put("http://localhost/crud.php?benchmark="+item.bench_name+"&id="+item.id, item, {});
  }

  public deleteResult(benchmark:string, id:string){
    /*
    Delete result
     */
    return this.http.delete("http://localhost/crud.php?benchmark="+benchmark+"&id="+id, {});
  }

  public resultsCount(){
    /*
    Count records
     */
    return this.benches.length;
  }
}
