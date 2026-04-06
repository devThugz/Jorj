# Load Dataset

dataset_path = 'datasets/DM_employee_dataset.csv'

data = pd.read_csv(dataset_path)
data.tail()

# Dataset Informantion

print(data.info())

# Dataset Summary

print(data.describe())  

# Print dataset size

#data.shape
print(f'Number of Rows: {data.shape[0]}')
print(f'Number of Cols: {data.shape[1]}')


# Print duplicate records

duplicate_rows = data[data.duplicated(keep = False)]

print("Duplicate rows: ")
print(duplicate_rows)

# Remove Duplicate Rows

data = data.drop_duplicates()
print(f'Dataset size after removing duplicates: {data.shape}')


print(data['City'].value_counts())


# Fix Inconsistent Text Values

data["City"] = data["City"].str.lower().str.strip()
print(data['City'].value_counts())


# Check Missing Values

print(data.isnull().sum())


# Handle Missing Values

# Fill using mode of missing data
data["Gender"].fillna(data["Gender"].mode()[0], inplace=True) # Cant compute mean for categorical values

# Fill using mean of missing data
data["Age"].fillna(data["Age"].mean(), inplace=True)

# Fill using median of missing data
data["Salary"].fillna(data["Salary"].median(), inplace=True)

# Fill using k-NN
numeric_cols = ["Experience"]
imputer = KNNImputer(n_neighbors=3)
data[numeric_cols] = imputer.fit_transform(data[numeric_cols])

# Fill using SimpleImputer
cat_imputer = SimpleImputer(strategy="constant", fill_value=100)  #Options: mean, median, most_frequent, constant
data[["Score"]] = cat_imputer.fit_transform(data[["Score"]])

print(data.isnull().sum())



data.tail()



# Remove Outliers (IQR Method)

num_cols = ['Age', 'Salary', 'Experience', 'Score']
for col in num_cols:

    Q1 = data[col].quantile(0.25)
    Q3 = data[col].quantile(0.75)
    
    IQR = Q3 - Q1
    
    lower = Q1 - 1.5 * IQR
    upper = Q3 + 1.5 * IQR
    
    data = data[(data[col] >= lower) & (data[col] <= upper)]
    
print(f'Dataset size after removing outliers: {data.shape}')



# Convert datatype

data["Age"] = data["Age"].astype(int)
data["Experience"] = data["Experience"].astype(int)
data["Salary"] = data["Salary"].astype(int)
data["Score"] = data["Score"].astype(int)

data.head()



# Feature Scaling (Standardization)
num_cols = ['Age', 'Salary']
scaler = StandardScaler()
data[num_cols] = scaler.fit_transform(data[num_cols])

# Normalization (Min-Max Scaling)
num_cols = ['Experience']
minmax = MinMaxScaler()
data[num_cols] = minmax.fit_transform(data[num_cols])

# Robust Scaling
num_cols = ['Score']
robust = RobustScaler()
data[num_cols] = robust.fit_transform(data[num_cols])

data.head()



# Label Encoding: Assign numeric lable to each category like IT: 1, HR: 2, Finance: 3

le = LabelEncoder()
data["Department"] = le.fit_transform(data["Department"])
data["Class"] = le.fit_transform(data["Class"])
data.head(3)



# One Hot Encoding: Encode each value of attribute as seperate variable

data = pd.get_dummies(data, columns=["Gender"])
data.head(3)



# Feature Engineering: Add new feature for more insight

data["Salary_per_Exp"] = data["Salary"] / (data["Experience"] + 1)
data.head(10)




# Save Cleaned Dataset

data.to_csv("datasets/DM_employee_dataset_cleaned.csv", index=False)
print("Preprocessing Completed Successfully")


