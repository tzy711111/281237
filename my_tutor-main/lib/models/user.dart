class User {
  String? id;
  String? name;
  String? phone;
  String? email;
  String? address;
  String? password;
  String? cart;

  User(
      {this.id, this.name, this.phone, this.email, this.address, this.password,  this.cart});

  User.fromJson(Map<String, dynamic> json) {
    id = json['id'];
    name = json['name'];
    phone = json['phone'];
    email = json['email'];
    address = json['address'];
    password = json['password'];
    cart = json['cart'].toString();
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = <String, dynamic>{};
    data['id'] = id;
    data['name'] = name;
    data['phone'] = phone;
    data['email'] = email;
    data['address'] = address;
    data['password'] = password;
    data['cart'] = cart.toString();
    return data;
  }
}