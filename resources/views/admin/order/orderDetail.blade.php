<tr>
    <th>排序</th>
    <th>订单编号</th>
    <th>名称</th>
  {{--  <th>规格</th>
    <th>颜色</th>--}}
    <th>价格</th>
    <th>数量</th>
</tr>
        @foreach($data as $k=> $v)
            <tr>
                <td class="tc" width="5%">
                    <span type="text" name="ord[]">{{$k+1}}</span>
                </td>
                <td class="tc" width="5%">{{$v->orderId}}</td>
                <td>{{$v->productName}}</td>
               {{-- <td></td>
                <td></td>--}}
                <td>{{$v->uintPrice}}</td>
                <td>{{$v->account}}</td>
            </tr>
        @endforeach