<div>
    <h1>{{ $count }}</h1>

    <button wire:click="add">+</button>

    <button wire:click="sub">-</button>

    <input type="text" wire:model.live.lazy="name">
    <h2>{{$name}}</h2>


    <div class="container">

        <div class="row">

            <div class="col-md-4">
                <h2>add new user</h2>
                <input type="text" wire:model='user'>
                <button wire:click="addData">add</button>
            </div>
            <div class="col-md-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">name</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($data as $n)
                        <tr>

                            <td>{{$loop->iteration}}</td>
                            <td>{{$n}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>


</div>