import csv

def parse_price(price_str):
    # Remove the currency symbol and commas
    cleaned_str = price_str.replace('₱', '').replace(',', '')
    # Convert to float and then to integer
    price_float = float(cleaned_str)
    return price_float

def dict_to_php_array(py_dict):
    php_array = "array("
    for key, value in py_dict.items():
        if isinstance(value, str):
            php_array += f"'{key}' => '{value}', "
        elif isinstance(value, (int, float)):
            php_array += f"'{key}' => {value}, "
        elif isinstance(value, dict):
            php_array += f"'{key}' => " + dict_to_php_array(value) + ", "
        else:
            raise TypeError(f"Unsupported data type: {type(value)}")
    php_array = php_array.rstrip(", ") + ")"
    return php_array

def csv_to_php_array(csv_file):
    php_array = []
    
    with open(csv_file, mode='r') as file:
        csv_reader = csv.reader(file, delimiter='%')
        next(csv_reader)  # Skip the header row
        
        for row in csv_reader:
            type_brand = f"({row[0]} {row[3]} - {row[2]}) {row[1]}"
            base_price = parse_price(row[4])
            profit = parse_price(row[5]) - parse_price(row[4])
            php_array.append({
                'name': type_brand,
                'base_price': base_price,
                'profit': round(profit, 1),
            })
    
    return php_array

# Example usage
csv_file = 'vegetable_seeds.csv'
php_array = csv_to_php_array(csv_file)

# Print the PHP array
for element in php_array:
    print(dict_to_php_array(element) + ',')
